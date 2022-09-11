<?php
/**
 * Created by G. Berger <greg@3kd.be> on PhpStorm.
 * Date: 10/09/2022
 * Time: 02:05
 */

namespace App\Service;



use App\Model\DTO\TimelineElement;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotionService
{

    public function __construct(private HttpClientInterface $httpClient,  private string $dbID)
    {
    }


    public function getDatabase(string|null $query=null) : array
    {
        $response =  $this->httpClient->request('POST', "v1/databases/$this->dbID/query", [
            'headers'=> [
                'Content-Type' => 'application/json'
            ],
            'body' => $query??'{"sorts" : [{"property":"Date","direction":"ascending"}]}'
        ]);
        return $response->toArray()['results'];
    }

    public function getTimelineElements() : array
    {
        $db = $this->getDatabase();
        $timelineElements = [];
        foreach ($db as $object){
            if($object['object'] !== 'page') {
                continue;
            }
            $timelineElements[]  = $this->getPropertiesFromPage($object['properties']);
        }
        return $timelineElements;
    }

    /**
     * @param array $properties
     * @return TimelineElement
     * @throws Exception
     */
    #[ArrayShape(
        ['url' => "string", 'origin' => "string", 'description' => "string", 'startDate' => "string|Datetime", 'endDate' => "string|Datetime", 'picture' => "mixed|null", 'location' => "string", 'type' => "mixed|string", 'title' => "mixed"]
    )]
    private function getPropertiesFromPage(array $properties): TimelineElement
    {
        return new TimelineElement(
            url: $properties['URL']['url'],
            title: $properties['Name']['title'][0]['plain_text'],
            description: $properties['Description']['rich_text'][0]['plain_text'],
            start: new \DateTime($properties['Date']['date']['start']),
            end: $properties['Date']['date']['end']?new \DateTime($properties['Date']['date']['end']):null,
            type: $properties['Type']['select']['name']??'',
            origin: $properties['Origin']['select']['name'],
            location: $properties['Location']['select']['name'],
            picture: $properties['Picture']['files'][0]??null
        );
    }
}
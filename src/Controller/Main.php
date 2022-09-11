<?php
/**
 * Created by G. Berger <greg@3kd.be> on PhpStorm.
 * Date: 10/09/2022
 * Time: 01:58
 */

namespace App\Controller;


use App\Service\NotionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Main extends AbstractController
{
    #[Route('/')]
    public function index(Request $req, NotionService $notionService): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/get-data')]
    public function jsonData(NotionService $notionService, Request $request) : JsonResponse
    {
        $timelineElements = $notionService->getTimelineElements();
        return new JsonResponse($timelineElements);
    }

}
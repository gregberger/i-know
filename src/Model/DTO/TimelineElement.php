<?php
/**
 * Created by G. Berger <greg@3kd.be> on PhpStorm.
 * Date: 11/09/2022
 * Time: 16:38
 */

namespace App\Model\DTO;


class TimelineElement
{
    public function __construct(
        public readonly string|null $url,
        public readonly string $title,
        public readonly string $description,
        public readonly \DateTime $start ,
        public readonly \DateTime|null $end,
        public readonly string $type,
        public readonly string $origin,
        public readonly string $location,
        public readonly array|null $picture,
    ) { }
}
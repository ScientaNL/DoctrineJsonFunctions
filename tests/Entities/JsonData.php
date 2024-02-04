<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class JsonData
{
    #[Id]
    #[Column(type: "string")]
    #[GeneratedValue]
    public $id;

    #[Column(type: "json")]
    public $jsonCol;

    #[Column(type: "json")]
    public $jsonData;
}

<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Blank
{
    #[Id, Column(type: Types::STRING), GeneratedValue]
    public $id;
}

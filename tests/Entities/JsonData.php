<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/** @Entity */
#[Entity]
class JsonData
{
    /** @Id @Column(type="string") @GeneratedValue */
    #[Id, Column(type: Types::STRING), GeneratedValue]
    public $id;

    /** @Column(type="json") */
    #[Column(type: Types::JSON)]
    public $jsonCol;

    /** @Column(type="json") */
    #[Column(type: Types::JSON)]
    public $jsonData;
}

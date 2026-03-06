<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\PostgresqlEntities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * PostgreSQL-specific test entity with native JSONB columns.
 * Unlike JsonData (which uses the json type and requires an ALTER TABLE to become jsonb),
 * this entity declares JSONB columns directly so the @> and related operators work
 * without any post-creation schema alteration.
 *
 * Lives outside tests/Entities/ so Doctrine's recursive entity scan does not
 * pick it up when non-PostgreSQL platforms create their schemas.
 */
#[Entity]
class JsonbData
{
    #[Id, Column(type: Types::STRING), GeneratedValue]
    public $id;

    #[Column(columnDefinition: 'JSONB')]
    public $jsonCol;

    #[Column(columnDefinition: 'JSONB')]
    public $jsonData;
}

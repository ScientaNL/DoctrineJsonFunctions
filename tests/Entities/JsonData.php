<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Entities;

/**
 * @Entity
 */
class JsonData
{
    /** @Id @Column(type="string") @GeneratedValue */
    public $id;

    /**
     * @Column(type="json_array")
     */
    public $jsonCol;

    /**
     * @Column(type="json_array")
     */
    public $jsonData;
}

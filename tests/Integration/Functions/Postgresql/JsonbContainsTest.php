<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbContainsTest extends PostgresqlIntegrationTestCase
{
    public function testContainsSubset(): void
    {
        // jsonCol {"a":1,"b":2} @> jsonData {"a":1} → true
        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }

    public function testDoesNotContain(): void
    {
        // jsonCol {"a":1} @> jsonData {"b":2} → false
        $this->insertJsonData(['a' => 1], ['b' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertFalse($result);
    }

    public function testFilterByJsonbContains(): void
    {
        // jsonCol {"a":1,"b":2} @> jsonData {"a":1} → true (row matches)
        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);
        // jsonCol {"a":1} @> jsonData {"b":2} → false (row does not match)
        $this->insertJsonData(['a' => 1], ['b' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j
             WHERE JSONB_CONTAINS(j.jsonCol, j.jsonData) = true"
        )->getResult();

        $this->assertCount(1, $result);
    }

    /**
     * Validates issue #77: JSONB_CONTAINS works correctly in a WHERE clause when the
     * column is jsonb-typed. This is the real-world use case (e.g. filtering by roles).
     */
    public function testFilterByContainment(): void
    {
        // jsonCol ["ROLE_ADMIN","ROLE_USER"] @> ["ROLE_ADMIN"] → matches
        $this->insertJsonData(['ROLE_ADMIN', 'ROLE_USER'], []);
        // jsonCol ["ROLE_USER"] @> ["ROLE_ADMIN"] → no match
        $this->insertJsonData(['ROLE_USER'], []);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j
             WHERE JSONB_CONTAINS(j.jsonCol, :roles) = true"
        )->setParameter('roles', '["ROLE_ADMIN"]')
         ->getResult();

        $this->assertCount(1, $result);
    }
}

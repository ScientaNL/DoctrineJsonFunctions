<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbSetTest extends PostgresqlIntegrationTestCase
{
    private const ENTITY = 'Scienta\DoctrineJsonFunctions\Tests\PostgresqlEntities\JsonbData';

    public function testReplacesExistingValue(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], []);

        $this->assertSame(
            ['a' => 99, 'b' => 2],
            $this->selectJsonbSet("'{a}'", "'99'")
        );
    }

    public function testCreatesMissingKeyByDefault(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], []);
        $this->assertArrayNotHasKey('c', $this->selectJsonColumn());

        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 99],
            $this->selectJsonbSet("'{c}'", "'99'")
        );
    }

    public function testCreateIfMissingDecidesWhetherAMissingKeyIsAdded(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], []);
        $this->assertArrayNotHasKey('c', $this->selectJsonColumn());

        $this->assertSame(
            ['a' => 1, 'b' => 2],
            $this->selectJsonbSet("'{c}'", "'99'", 'false')
        );
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 99],
            $this->selectJsonbSet("'{c}'", "'99'", 'true')
        );
    }

    public function testAcceptsBoundParameters(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], []);

        $this->assertSame(
            ['a' => 99, 'b' => 2],
            $this->selectJsonbSet(':path', ':value', null, ['path' => '{a}', 'value' => '99'])
        );
    }

    /**
     * @param array<string, string> $parameters
     * @return array<string, mixed>
     */
    private function selectJsonbSet(string $path, string $value, ?string $createIfMissing = null, array $parameters = []): array
    {
        $arguments = $createIfMissing === null
            ? "j.jsonCol, $path, $value"
            : "j.jsonCol, $path, $value, $createIfMissing";

        $query = $this->entityManager->createQuery(
            'SELECT JSONB_SET(' . $arguments . ') AS val FROM ' . self::ENTITY . ' j'
        );
        foreach ($parameters as $name => $parameterValue) {
            $query->setParameter($name, $parameterValue);
        }

        return $this->decode($query->getSingleScalarResult());
    }

    /** @return array<string, mixed> */
    private function selectJsonColumn(): array
    {
        return $this->decode(
            $this->entityManager->createQuery('SELECT j.jsonCol FROM ' . self::ENTITY . ' j')->getSingleScalarResult()
        );
    }

    /** @return array<string, mixed> */
    private function decode(mixed $result): array
    {
        $decoded = json_decode((string) $result, true);
        $this->assertIsArray($decoded);

        return $decoded;
    }
}

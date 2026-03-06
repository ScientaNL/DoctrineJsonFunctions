[![Latest Stable Version](https://poser.pugx.org/scienta/doctrine-json-functions/v/stable?format=flat)](https://packagist.org/packages/scienta/doctrine-json-functions)
[![Total Downloads](https://poser.pugx.org/scienta/doctrine-json-functions/downloads?format=flat)](https://packagist.org/packages/scienta/doctrine-json-functions)
[![License](https://poser.pugx.org/scienta/doctrine-json-functions/license)](https://packagist.org/packages/scienta/doctrine-json-functions)
[![Unittest Coverage](https://img.shields.io/endpoint?url=https://raw.githubusercontent.com/ScientaNL/DoctrineJsonFunctions/badges/coverage.json)](https://github.com/ScientaNL/DoctrineJsonFunctions/actions/workflows/coverage.yml)
[![Integrationtest Coverage](https://img.shields.io/endpoint?url=https://raw.githubusercontent.com/ScientaNL/DoctrineJsonFunctions/badges/coverage-integration.json)](https://github.com/ScientaNL/DoctrineJsonFunctions/actions/workflows/coverage.yml)

# DoctrineJsonFunctions

A set of extensions to Doctrine ORM that add support for JSON functions in DQL (Doctrine Query Language). Supports MySQL, MariaDB, PostgreSQL, SQLite, and SQL Server.

## Overview

Doctrine ORM does not natively support database-specific JSON functions in DQL. This library bridges that gap by registering custom DQL function nodes for each supported platform. Each function validates at SQL generation time that the correct database platform is in use, so you get an early error if a function is used against the wrong database.

### Supported Platforms and Functions

| Database | Functions |
|----------|-----------|
| MySQL 5.7+ / MariaDB | `JSON_ARRAY`, `JSON_ARRAY_APPEND`, `JSON_ARRAY_INSERT`, `JSON_ARRAYAGG`, `JSON_CONTAINS`, `JSON_CONTAINS_PATH`, `JSON_DEPTH`, `JSON_EXTRACT`, `JSON_INSERT`, `JSON_KEYS`, `JSON_LENGTH`, `JSON_MERGE`, `JSON_MERGE_PATCH`, `JSON_MERGE_PRESERVE`, `JSON_OBJECT`, `JSON_OBJECTAGG`, `JSON_OVERLAPS`, `JSON_PRETTY`, `JSON_QUOTE`, `JSON_REMOVE`, `JSON_REPLACE`, `JSON_SEARCH`, `JSON_SET`, `JSON_TYPE`, `JSON_UNQUOTE`, `JSON_VALID` |
| MySQL 8.0.21+ only | `JSON_VALUE` |
| MariaDB only | `JSON_COMPACT`, `JSON_DETAILED`, `JSON_EQUALS`, `JSON_EXISTS`, `JSON_LOOSE`, `JSON_NORMALIZE`, `JSON_QUERY`, `JSON_VALUE` |
| PostgreSQL 9.3+ | `JSONB_CONTAINS`, `JSONB_EXISTS`, `JSONB_EXISTS_ALL`, `JSONB_EXISTS_ANY`, `JSONB_INSERT`, `JSONB_IS_CONTAINED`, `JSON_EXTRACT_PATH`, `JSON_GET`, `JSON_GET_PATH`, `JSON_GET_PATH_TEXT`, `JSON_GET_TEXT` |
| SQLite (json1 ext.) | `JSON`, `JSON_ARRAY`, `JSON_ARRAY_LENGTH`, `JSON_EXTRACT`, `JSON_GROUP_ARRAY`, `JSON_GROUP_OBJECT`, `JSON_INSERT`, `JSON_OBJECT`, `JSON_PATCH`, `JSON_QUOTE`, `JSON_REMOVE`, `JSON_REPLACE`, `JSON_SET`, `JSON_TYPE`, `JSON_VALID` |
| SQL Server 2016+ | `JSON_VALUE` |

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Testing](#testing)
- [Registration](#registration)
  - [Doctrine ORM](#doctrine-orm)
  - [Symfony with DoctrineBundle](#symfony-with-doctrinebundle)
- [Usage](#usage)
  - [MySQL / MariaDB](#mysql--mariadb)
  - [PostgreSQL](#postgresql)
  - [SQLite](#sqlite)
  - [SQL Server](#sql-server)
- [DQL Function Reference](#dql-function-reference)
  - [MySQL 5.7+ and MariaDB (shared)](#mysql-57-and-mariadb-shared)
  - [MySQL 8.0.21+ only](#mysql-8021-only)
  - [MariaDB only](#mariadb-only)
  - [PostgreSQL 9.3+](#postgresql-93)
  - [SQLite json1 extension](#sqlite-json1-extension)
  - [SQL Server 2016+](#sql-server-2016)
- [Architecture](#architecture)
- [Extending the Library](#extending-the-library)
  - [Adding a new function](#adding-a-new-function)
  - [Adding a new platform](#adding-a-new-platform)
- [Changelog](#changelog)
- [See Also](#see-also)


## Requirements

- PHP 8.1+
- `doctrine/orm`: `^2.19` or `^3`
- `doctrine/dbal`: `^3.2` or `^4`
- `doctrine/lexer`: `^2.0` or `^3.0`


## Installation

Install via Composer:

```bash
composer require scienta/doctrine-json-functions
```

## Testing

This repository uses PHPUnit. There are two test suites:

- **Unit tests** — mock the Doctrine infrastructure, no real database needed
- **Integration tests** — run DQL queries against real MySQL, MariaDB, PostgreSQL, and SQLite databases

### Unit tests

```bash
composer install
composer test:unit
```

Or with Docker Compose (PHP 8.4):

```bash
docker compose up -d --build --wait
docker compose exec php composer test:unit
```

### Code coverage

The Docker image includes the PCOV extension. Run the unit tests with Clover coverage output:

```bash
docker compose up -d --build --wait
docker compose run --rm php bash -c "composer install && composer test:coverage"
```

This writes `coverage.xml` to the project root. Coverage is also reported automatically on every PR and push to `master` via the [Coverage workflow](https://github.com/ScientaNL/DoctrineJsonFunctions/actions/workflows/coverage.yml).

### Integration test coverage

PCOV is available inside the container. Start the database services first, then run:

```bash
docker compose up -d --build --wait
docker compose exec php bash -c "composer install && composer test:coverage:integration"
```

This writes `coverage-integration.xml` to the project root. Integration coverage is also reported automatically on every PR alongside unit coverage.

### Integration tests

Start the database containers, then run the tests inside the PHP container:

```bash
docker compose up -d --build --wait
docker compose exec php composer test:integration
```

Run a single platform:

```bash
docker compose exec php composer test:integration:mysql
docker compose exec php composer test:integration:mariadb
docker compose exec php composer test:integration:postgres
docker compose exec php composer test:integration:sqlite
docker compose exec php composer test:integration:mssql
```

**Running locally without Docker:** copy `.env.dist` to `.env`, fill in your connection URLs, then:

```bash
export $(grep -v '^#' .env | xargs)
composer test:integration
```

SQLite always runs in-memory and needs no configuration.

## Registration

All functions must be registered as **custom string functions** in the Doctrine configuration before they can be used in DQL. Each function class exposes a `FUNCTION_NAME` constant that matches the DQL keyword you use in queries.

> **Note on boolean functions:** Doctrine DQL does not have a native boolean function type ([upstream issue](https://github.com/doctrine/orm/issues/6278)). Register boolean-returning functions (e.g., `JSONB_CONTAINS`, `JSON_CONTAINS`) as `string_functions` and compare them explicitly with `= true` or `= 1` in your DQL to avoid parser errors.

### Doctrine ORM

```php
<?php

use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql as MysqlFunctions;

$config = new \Doctrine\ORM\Configuration();

// Register the functions you need (example: MySQL)
$config->addCustomStringFunction(MysqlFunctions\JsonExtract::FUNCTION_NAME, MysqlFunctions\JsonExtract::class);
$config->addCustomStringFunction(MysqlFunctions\JsonContains::FUNCTION_NAME, MysqlFunctions\JsonContains::class);
$config->addCustomStringFunction(MysqlFunctions\JsonUnquote::FUNCTION_NAME, MysqlFunctions\JsonUnquote::class);

$em = EntityManager::create($dbParams, $config);
```

### Symfony with DoctrineBundle

```yaml
# config/packages/doctrine.yaml
doctrine:
    orm:
        dql:
            string_functions:
                # MySQL / MariaDB shared
                JSON_EXTRACT:        Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract
                JSON_CONTAINS:       Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonContains
                JSON_UNQUOTE:        Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonUnquote
                JSON_SEARCH:         Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch
                # PostgreSQL
                JSONB_CONTAINS:      Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbContains
                JSONB_EXISTS:        Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbExists
                JSON_GET:            Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonGet
                JSON_GET_TEXT:       Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonGetText
                # SQL Server
                JSON_VALUE:          Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mssql\JsonValue
```


## Usage

Use the registered DQL function names directly in your DQL queries or query builders. JSON path expressions must use single-quoted strings in DQL (not double-quoted).

### MySQL / MariaDB

```php
// Extract a value from a JSON column
$results = $em->createQuery(
    "SELECT c FROM App\Entity\Customer c
     WHERE JSON_UNQUOTE(JSON_EXTRACT(c.attributes, '$.country')) = :country"
)->setParameter('country', 'NL')->getResult();

// Check if a JSON array contains a value
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->where("JSON_CONTAINS(c.roles, :role) = 1")
    ->setParameter('role', '"admin"')
    ->getQuery()->getResult();

// Use JSON_SEARCH to find a path
$q = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->where("JSON_SEARCH(c.attributes, 'one', :cert, null, '$.certificates') IS NOT NULL")
    ->setParameter('cert', 'BIO');
```

### PostgreSQL

PostgreSQL operators (`->`, `->>`, `@>`, `?`, etc.) are exposed as named DQL functions because Doctrine DQL does not support custom operators.

```php
// Get a JSON object field as text
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->where("JSON_GET_TEXT(c.attributes, 'country') = :country")
    ->setParameter('country', 'NL')
    ->getQuery()->getResult();

// Check JSONB containment (boolean — must compare with = true)
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->andWhere('JSONB_CONTAINS(c.roles, :role) = true')
    ->setParameter('role', '"ROLE_ADMIN"')
    ->getQuery()->getResult();

// Check if a key exists in a JSONB column
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->andWhere('JSONB_EXISTS(c.data, :key) = true')
    ->setParameter('key', 'active')
    ->getQuery()->getResult();
```

> PostgreSQL operator chaining (e.g., `col->'a'->'b'`) is not supported. Use `JSON_GET_PATH` (works on both `json` and `jsonb`) or `JSON_EXTRACT_PATH` (`json` columns only) instead.

### SQLite

```php
// Extract a field from a JSON column
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->where("JSON_EXTRACT(c.attributes, '$.country') = :country")
    ->setParameter('country', 'NL')
    ->getQuery()->getResult();
```

### SQL Server

```php
// Extract a scalar value from a JSON column
$results = $queryBuilder
    ->select('c')
    ->from('App\Entity\Customer', 'c')
    ->where("JSON_VALUE(c.attributes, '$.country') = :country")
    ->setParameter('country', 'NL')
    ->getQuery()->getResult();
```

> To apply type conversion, use `CAST` outside the function:
> `CAST(JSON_VALUE(c.attributes, '$.score') AS DECIMAL(4,2))`


## DQL Function Reference

### MySQL 5.7+ and MariaDB (shared)

All functions in the `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql` namespace unless noted. Functions marked as shared also work on MariaDB (they are registered under the MySQL namespace but validate against `AbstractMySQLPlatform` / `MariaDBPlatform`).

| DQL Function | Class | Signature | Description |
|---|---|---|---|
| `JSON_ARRAY` | `JsonArray` | `JSON_ARRAY([val, ...])` | Creates a JSON array from arguments |
| `JSON_ARRAY_APPEND` | `JsonArrayAppend` | `JSON_ARRAY_APPEND(doc, path, val[, ...])` | Appends values to JSON arrays |
| `JSON_ARRAY_INSERT` | `JsonArrayInsert` | `JSON_ARRAY_INSERT(doc, path, val[, ...])` | Inserts into a JSON array |
| `JSON_ARRAYAGG` | `JsonArrayAgg` | `JSON_ARRAYAGG(value)` | Aggregate: builds a JSON array from rows |
| `JSON_CONTAINS` | `JsonContains` | `JSON_CONTAINS(doc, val[, path])` | Returns 1 if doc contains val |
| `JSON_CONTAINS_PATH` | `JsonContainsPath` | `JSON_CONTAINS_PATH(doc, one_or_all, path[, ...])` | Returns 1 if path(s) exist |
| `JSON_DEPTH` | `JsonDepth` | `JSON_DEPTH(doc)` | Returns maximum depth of document |
| `JSON_EXTRACT` | `JsonExtract` | `JSON_EXTRACT(doc, path[, ...])` | Extracts data from a JSON document |
| `JSON_INSERT` | `JsonInsert` | `JSON_INSERT(doc, path, val[, ...])` | Inserts data into a JSON document |
| `JSON_KEYS` | `JsonKeys` | `JSON_KEYS(doc[, path])` | Returns top-level keys as a JSON array |
| `JSON_LENGTH` | `JsonLength` | `JSON_LENGTH(doc[, path])` | Returns the length of a JSON document or value |
| `JSON_MERGE` | `JsonMerge` | `JSON_MERGE(doc, doc[, ...])` | Merges JSON documents (deprecated alias) |
| `JSON_MERGE_PATCH` | `JsonMergePatch` | `JSON_MERGE_PATCH(doc, doc[, ...])` | RFC 7396 merge patch |
| `JSON_MERGE_PRESERVE` | `JsonMergePreserve` | `JSON_MERGE_PRESERVE(doc, doc[, ...])` | Merges preserving duplicate keys |
| `JSON_OBJECT` | `JsonObject` | `JSON_OBJECT([key, val, ...])` | Creates a JSON object |
| `JSON_OBJECTAGG` | `JsonObjectAgg` | `JSON_OBJECTAGG(key, val)` | Aggregate: builds a JSON object from rows |
| `JSON_OVERLAPS` | `JsonOverlaps` | `JSON_OVERLAPS(doc1, doc2)` | Returns 1 if documents share key-value pairs or array elements |
| `JSON_PRETTY` | `JsonPretty` | `JSON_PRETTY(val)` | Returns pretty-printed JSON |
| `JSON_QUOTE` | `JsonQuote` | `JSON_QUOTE(val)` | Quotes a string as a JSON value |
| `JSON_REMOVE` | `JsonRemove` | `JSON_REMOVE(doc, path[, ...])` | Removes data from a JSON document |
| `JSON_REPLACE` | `JsonReplace` | `JSON_REPLACE(doc, path, val[, ...])` | Replaces existing values |
| `JSON_SEARCH` | `JsonSearch` | `JSON_SEARCH(doc, one\|all, str[, escape[, path...]])` | Returns path to a string in a document |
| `JSON_SET` | `JsonSet` | `JSON_SET(doc, path, val[, ...])` | Inserts or updates values |
| `JSON_TYPE` | `JsonType` | `JSON_TYPE(val)` | Returns the JSON type string |
| `JSON_UNQUOTE` | `JsonUnquote` | `JSON_UNQUOTE(val)` | Unquotes a JSON value |
| `JSON_VALID` | `JsonValid` | `JSON_VALID(val)` | Returns 1 if value is valid JSON |

> MySQL functions that also apply to MariaDB use `MysqlAndMariadbJsonFunctionNode` as their base, which validates against `AbstractMySQLPlatform` (DBAL 3.3+) or `MySQLPlatform` (older DBAL).

### MySQL 8.0.21+ only

| DQL Function | Class | Signature | Description |
|---|---|---|---|
| `JSON_VALUE` | `JsonValue` | `JSON_VALUE(doc, path[, RETURNING type])` | Extracts a scalar value; supports `RETURNING DECIMAL(n,m)`, `RETURNING CHAR`, etc. |

This function uses `MysqlJsonFunctionNode` and only works on MySQL (not MariaDB).

### MariaDB only

Namespace: `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb`

| DQL Function | Class | Available Since | Description |
|---|---|---|---|
| `JSON_VALUE` | `JsonValue` | MariaDB 10.2.3 | Extracts a scalar value at a path |
| `JSON_EXISTS` | `JsonExists` | MariaDB 10.2.3 | Returns 1 if path exists in document |
| `JSON_QUERY` | `JsonQuery` | MariaDB 10.2.3 | Returns an object or array at a path |
| `JSON_COMPACT` | `JsonCompact` | MariaDB 10.2.4 | Removes unnecessary whitespace from JSON |
| `JSON_DETAILED` | `JsonDetailed` | MariaDB 10.2.4 | Returns human-readable formatted JSON |
| `JSON_LOOSE` | `JsonLoose` | MariaDB 10.2.4 | Adds spaces for readability |
| `JSON_EQUALS` | `JsonEquals` | MariaDB 10.7.0 | Returns 1 if two JSON documents are equal |
| `JSON_NORMALIZE` | `JsonNormalize` | MariaDB 10.7.0 | Sorts keys and removes spaces for comparison |

> MySQL operators like `JSON_EXTRACT` are also available on MariaDB — register them from the `Mysql` namespace.

### PostgreSQL 9.3+

Namespace: `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql`

PostgreSQL JSON operators are wrapped as named functions. SQL output uses the native operators.

| DQL Function | Class | SQL Equivalent | Description |
|---|---|---|---|
| `JSONB_CONTAINS` | `JsonbContains` | `jsonb @> jsonb` | Returns true if left contains right |
| `JSONB_EXISTS` | `JsonbExists` | native `jsonb_exists(jsonb, text)` | Returns true if key exists in JSONB |
| `JSONB_EXISTS_ALL` | `JsonbExistsAll` | native `jsonb_exists_all(jsonb, text[])` | Returns true if all keys exist |
| `JSONB_EXISTS_ANY` | `JsonbExistsAny` | native `jsonb_exists_any(jsonb, text[])` | Returns true if any key exists |
| `JSONB_INSERT` | `JsonbInsert` | native `jsonb_insert(...)` | Inserts a value into a JSONB document |
| `JSONB_IS_CONTAINED` | `JsonbIsContained` | `jsonb <@ jsonb` | Returns true if left is contained by right |
| `JSON_EXTRACT_PATH` | `JsonExtractPath` | native `json_extract_path(...)` | Extracts a JSON sub-object at a path (`json` columns only, not `jsonb`) |
| `JSON_GET` | `JsonGet` | `json -> key` (numeric: `->` int, text: `->` 'key') | Returns a JSON field/element |
| `JSON_GET_TEXT` | `JsonGetText` | `json ->> key` | Returns a JSON field/element as text |
| `JSON_GET_PATH` | `JsonGetPath` | `json #> '{path}'` | Extracts a sub-object at path array |
| `JSON_GET_PATH_TEXT` | `JsonGetPathText` | `json #>> '{path}'` | Extracts a sub-object at path array as text |

**Boolean functions** (`JSONB_CONTAINS`, `JSONB_EXISTS`, `JSONB_EXISTS_ALL`, `JSONB_EXISTS_ANY`, `JSONB_IS_CONTAINED`) must be compared with `= true` due to the Doctrine DQL boolean function limitation:

```php
->andWhere('JSONB_CONTAINS(e.data, :val) = true')
```

### SQLite json1 extension

Namespace: `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite`

SQLite must have the [json1 extension](https://www.sqlite.org/json1.html) enabled (it is compiled in by default since SQLite 3.38.0).

#### Scalar functions

| DQL Function | Class | Signature | Description |
|---|---|---|---|
| `JSON` | `Json` | `JSON(json)` | Validates and minifies a JSON string |
| `JSON_ARRAY` | `JsonArray` | `JSON_ARRAY([val, ...])` | Creates a JSON array |
| `JSON_ARRAY_LENGTH` | `JsonArrayLength` | `JSON_ARRAY_LENGTH(json[, path])` | Returns the number of elements in an array |
| `JSON_EXTRACT` | `JsonExtract` | `JSON_EXTRACT(json, path[, ...])` | Extracts one or more values |
| `JSON_INSERT` | `JsonInsert` | `JSON_INSERT(json[, path, value, ...])` | Inserts values without overwriting |
| `JSON_OBJECT` | `JsonObject` | `JSON_OBJECT(label, value[, ...])` | Creates a JSON object |
| `JSON_PATCH` | `JsonPatch` | `JSON_PATCH(target, patch)` | Applies an RFC 7396 merge patch |
| `JSON_QUOTE` | `JsonQuote` | `JSON_QUOTE(value)` | Converts a SQL value to its JSON representation |
| `JSON_REMOVE` | `JsonRemove` | `JSON_REMOVE(json[, path, ...])` | Removes values at given paths |
| `JSON_REPLACE` | `JsonReplace` | `JSON_REPLACE(json[, path, value, ...])` | Overwrites values at given paths |
| `JSON_SET` | `JsonSet` | `JSON_SET(json[, path, value, ...])` | Inserts or overwrites values |
| `JSON_TYPE` | `JsonType` | `JSON_TYPE(json[, path])` | Returns the type of a JSON value |
| `JSON_VALID` | `JsonValid` | `JSON_VALID(json)` | Returns 1 if argument is valid JSON |

#### Aggregate functions

| DQL Function | Class | Signature | Description |
|---|---|---|---|
| `JSON_GROUP_ARRAY` | `JsonGroupArray` | `JSON_GROUP_ARRAY(value)` | Aggregates all values into a JSON array |
| `JSON_GROUP_OBJECT` | `JsonGroupObject` | `JSON_GROUP_OBJECT(name, value)` | Aggregates name/value pairs into a JSON object |

### SQL Server 2016+

Namespace: `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mssql`

| DQL Function | Class | Signature | Description |
|---|---|---|---|
| `JSON_VALUE` | `JsonValue` | `JSON_VALUE(doc, path)` | Extracts a scalar value from a JSON string at the given path |

> SQL Server does not support inline type conversion inside `JSON_VALUE`. Use `CAST(JSON_VALUE(...) AS type)` in your DQL for type conversion.


## Architecture

### Class Hierarchy

The library uses a layered inheritance model to separate argument parsing (generic) from platform validation (platform-specific):

```
Doctrine\ORM\Query\AST\Functions\FunctionNode
└── AbstractJsonFunctionNode               # argument parsing, SQL generation
    ├── AbstractJsonOperatorFunctionNode   # for functions that map to SQL operators (e.g., @>, ->)
    ├── Mysql\MysqlJsonFunctionNode        # validates MySQLPlatform only
    ├── Mysql\MysqlAndMariadbJsonFunctionNode  # validates AbstractMySQLPlatform (MySQL + MariaDB)
    ├── Mariadb\MariadbJsonFunctionNode    # validates MariaDBPlatform only
    ├── Postgresql\PostgresqlJsonFunctionNode   # validates PostgreSQLPlatform
    ├── Postgresql\PostgresqlJsonOperatorFunctionNode  # PostgreSQL operator-style functions
    ├── Sqlite\SqliteJsonFunctionNode      # validates SQLitePlatform
    └── Mssql\MssqlJsonFunctionNode        # validates SQLServerPlatform
```

Each concrete function class only needs to declare:
- `FUNCTION_NAME` constant — the DQL keyword
- `$requiredArgumentTypes` — argument types that must be present
- `$optionalArgumentTypes` — argument types that may optionally be present
- `$allowOptionalArgumentRepeat` — whether optional args can repeat (variadic)

### Argument Types

| Constant | Parser Method | Accepts |
|---|---|---|
| `STRING_PRIMARY_ARG` | `StringPrimary()` | column path, parameter, subquery, string literal |
| `STRING_ARG` | literal match | single-quoted string literal only |
| `ALPHA_NUMERIC` | literal match | string, integer, or float literal |
| `VALUE_ARG` | `NewValue()` | a new value (used in insert/update functions) |

### Naming Convention

```
Scienta\DoctrineJsonFunctions\Query\AST\Functions\{Platform}\{FunctionName}
```

Examples:
- `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract`
- `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbContains`
- `Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb\JsonCompact`

### DBAL Version Compatibility

`DBALCompatibility` is an internal helper that resolves class names that changed between DBAL 3 and DBAL 4:

| Platform | DBAL < 3.3 | DBAL 3.3+ / 4 |
|---|---|---|
| MariaDB | `MySQLPlatform` | `MariaDBPlatform` |
| MySQL+MariaDB shared | `MySQLPlatform` | `AbstractMySQLPlatform` |
| SQLite | `SqlitePlatform` | `SQLitePlatform` |


## Extending the Library

### Adding a new function

1. Create a class in the appropriate platform namespace extending the platform's base node class.
2. Declare `FUNCTION_NAME`, `$requiredArgumentTypes`, `$optionalArgumentTypes`, and `$allowOptionalArgumentRepeat`.
3. Override `parse()` and/or `getSqlForArgs()` only if the function has non-standard argument syntax.

**Example — a simple single-argument MySQL function:**

```php
<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

class JsonMyNewFunction extends MysqlAndMariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_MY_NEW_FUNCTION';

    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
```

Register it:
```php
$config->addCustomStringFunction(JsonMyNewFunction::FUNCTION_NAME, JsonMyNewFunction::class);
```

Use it in DQL:
```dql
SELECT JSON_MY_NEW_FUNCTION(e.jsonColumn) FROM App\Entity\MyEntity e
```

### Adding a new platform

1. Create a new namespace folder: `src/Query/AST/Functions/{PlatformName}/`
2. Create a base node class that extends `AbstractJsonFunctionNode` and implements `validatePlatform()` to check the correct `DatabasePlatform` instance.
3. Add platform detection to `DBALCompatibility` if needed (e.g., when the class name differs between DBAL versions).
4. Implement individual function classes extending your new base.

**Example base node:**

```php
<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\MyNewDb;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\MyNewDbPlatform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

abstract class MyNewDbJsonFunctionNode extends AbstractJsonFunctionNode
{
    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof MyNewDbPlatform) {
            throw new Exception("Platform not supported");
        }
    }
}
```


## Changelog

Changes per release are documented in [GitHub releases](https://github.com/ScientaNL/DoctrineJsonFunctions/releases).


## See Also

- [dunglas/doctrine-json-odm](https://github.com/dunglas/doctrine-json-odm) — serialize/deserialize plain PHP objects as JSON columns using Doctrine ORM
- [Doctrine DQL User Defined Functions](http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html)
- [MySQL JSON function reference](https://dev.mysql.com/doc/refman/8.0/en/json-functions.html)
- [PostgreSQL JSON function reference](https://www.postgresql.org/docs/current/functions-json.html)
- [MariaDB JSON function reference](https://mariadb.com/kb/en/json-functions/)
- [SQLite json1 extension reference](https://www.sqlite.org/json1.html)

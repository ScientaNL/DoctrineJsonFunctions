[![Latest Stable Version](https://poser.pugx.org/scienta/doctrine-json-functions/v/stable?format=flat)](https://packagist.org/packages/scienta/doctrine-json-functions)
[![Total Downloads](https://poser.pugx.org/scienta/doctrine-json-functions/downloads?format=flat)](https://packagist.org/packages/scienta/doctrine-json-functions)
[![License](https://poser.pugx.org/scienta/doctrine-json-functions/license)](https://packagist.org/packages/scienta/doctrine-json-functions)

# DoctrineJsonFunctions
A set of extensions to Doctrine 2 that add support for json query functions.
+Functions are available for MySQL, MariaDb and PostgreSQL.

| DB | Functions |
|:--:|:---------:|
| MySQL | `JSON_APPEND, JSON_ARRAY, JSON_ARRAY_APPEND, JSON_ARRAY_INSERT, JSON_CONTAINS, JSON_CONTAINS_PATH, JSON_DEPTH, JSON_EXTRACT, JSON_INSERT, JSON_KEYS, JSON_LENGTH, JSON_MERGE, JSON_MERGE_PATCH, JSON_OBJECT, JSON_PRETTY, JSON_QUOTE, JSON_REMOVE, JSON_REPLACE, JSON_SEARCH, JSON_SET, JSON_TYPE, JSON_UNQUOTE, JSON_VALID` |
| PostgreSQL | `JSON_EXTRACT_PATH, GT, GT_GT, SHARP_GT, SHARP_GT_GT` |
| MariaDb | `JSON_VALUE, JSON_EXISTS` |
| SQLite | `JSON, JSON_ARRAY, JSON_ARRAY_LENGTH, JSON_EXTRACT, JSON_GROUP_ARRAY, JSON_GROUP_OBJECT, JSON_INSERT, JSON_OBJECT, JSON_PATCH, JSON_QUOTE, JSON_REMOVE, JSON_REPLACE, JSON_SET, JSON_TYPE, JSON_VALID` |

Table of Contents
-----------------

- [Changelog per release](#changelog)
- [Installation](#installation)
- [Testing](#testing)
- [Functions Registration](#functions-registration)
  - [Doctrine 2](#vanilla-doctrine-2-orm)
  - [Symfony 2 & 3](#symfony-2--3-with-doctrine-bundle)
- [Usage](#usage)
  - [Using Mysql 5.7+ JSON operators](#using-mysql-57-json-operators)
  - [Using PostgreSQL 9.3+ JSON operators](#using-postgresql-93-json-operators)
  - [Using SQLite JSON operators](#using-sqlite-json-operators)
- [DQL Functions](#dql-functions)
    - [Mysql 5.7+ JSON operators](#mysql-57-json-operators)
    - [PostgreSQL 9.3+ JSON operators](#postgresql-93-json-operators)
    - [SQLite json1 extension operators](#sqlite-json1-extension-operators)
- [Extendability and Database Support](#extendability-and-database-support)
  - [Architecture](#architecture)
  - [Adding new platform](#adding-a-new-platform)
  - [Adding new function](#adding-a-new-function)


Changelog
------------
Changes per release are documented with each github release.
You can find an overview here: https://github.com/ScientaNL/DoctrineJsonFunctions/releases


Installation
------------
The recommended way to install DoctrineJsonFunctions is through [Composer](https://getcomposer.org/).
Add the following dependency to your composer.json
```json
{
	"require": {
		"scienta/doctrine-json-functions": "~4.3"
	}
}
```
Alternatively, you can download the [source code as a file](https://github.com/ScientaNL/DoctrineJsonFunctions/releases) and extract it.


Testing
------------
This repository uses phpunit for testing purposes.
If you just want to run the tests you can use the docker composer image to install and run phpunit.
There is a docker-compose file with the correct mount but if you want to use just docker you can run this:

### php7
```bash
docker run -it -v ${PWD}:/app scienta/php-composer:php7 /bin/bash -c "composer install && ./vendor/bin/phpunit"
```

### php8
```bash
docker run -it -v ${PWD}:/app scienta/php-composer:php8 /bin/bash -c "composer install && ./vendor/bin/phpunit"
```


Functions Registration
----------------------

### Doctrine 2 ORM

[Doctrine 2 documentation: "DQL User Defined Functions"](http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html)

```php
<?php

use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql as DqlFunctions;

$config = new \Doctrine\ORM\Configuration();
$config->addCustomStringFunction(DqlFunctions\JsonExtract::FUNCTION_NAME, DqlFunctions\JsonExtract::class);
$config->addCustomStringFunction(DqlFunctions\JsonSearch::FUNCTION_NAME, DqlFunctions\JsonSearch::class);

$em = EntityManager::create($dbParams, $config);
$queryBuilder = $em->createQueryBuilder();
```

### Symfony 2 & 3 with Doctrine bundle

[Symfony documentation: "DoctrineBundle Configuration"](https://symfony.com/doc/3.3/reference/configuration/doctrine.html#full-default-configuration)

```yaml
# app/config/config.yml
doctrine:
    orm:
        entity_managers:
            some_em: # usually also "default"
                dql:
                    string_functions:
                        JSON_EXTRACT: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract
                        JSON_SEARCH: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch
```

### Symfony 5 with Doctrine bundle

[Symfony documentation: "DoctrineBundle Configuration"](https://symfony.com/doc/5.0/reference/configuration/doctrine.html#shortened-configuration-syntax)

```yaml
# config/packages/doctrine.yaml
doctrine:
    orm:
        dql:
            string_functions:
                JSON_EXTRACT: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonExtract
                JSON_SEARCH: Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonSearch
```


Usage
-----

Mind the comparison when creating the expression and escape the parameters to be valid JSON.

### Using Mysql 5.7+ JSON operators
```php
$q = $queryBuilder
  ->select('c')
  ->from('Customer', 'c')
  ->where("JSON_CONTAINS(c.attributes, :certificates, '$.certificates') = 1");

$result = $q->execute(array(
  'certificates' => '"BIO"',
));
```

### Using PostgreSQL 9.3+ JSON operators
```php
$q = $queryBuilder
  ->select('c')
  ->from('Customer', 'c')
  ->where("JSON_GET_TEXT(c.attributes, 'gender') = :gender");

 $result = $q->execute(array(
    'gender' => 'male',
 ));
```

### Using SQLite JSON operators
```php
$q = $queryBuilder
  ->select('c')
  ->from('Customer', 'c')
  ->where("JSON_EXTRACT(c.attributes, '$.gender') = :gender");

 $result = $q->execute();
```

DQL Functions
-------------

The library provides this set of DQL functions.

### Mysql 5.7+ JSON operators
* [JSON_ARRAY_APPEND(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-array-append)
	- Appends values to the end of the indicated arrays within a JSON document and returns the result.
* [JSON_ARRAY_INSERT(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-array-insert)
	- Updates a JSON document, inserting into an array within the document and returning the modified document.
* [JSON_ARRAY([val[, val] ...])](https://dev.mysql.com/doc/refman/5.7/en/json-creation-functions.html#function_json-array)
	- Evaluates a (possibly empty) list of values and returns a JSON array containing those values.
* [JSON_CONTAINS_PATH(json_doc, one_or_all, path[, path] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-search-functions.html#function_json-contains-path)
	- Returns 0 or 1 to indicate whether a JSON document contains data at a given path or paths.
* [JSON_CONTAINS(json_doc, val[, path])](https://dev.mysql.com/doc/refman/5.7/en/json-search-functions.html#function_json-contains)
	- Returns 0 or 1 to indicate whether a specific value is contained in a target JSON document, or, if a path argument is given, at a specific path within the target document.
* [JSON_DEPTH(json_doc)](https://dev.mysql.com/doc/refman/5.7/en/json-attribute-functions.html#function_json-depth)
	- Returns the maximum depth of a JSON document.
* [JSON_EXTRACT(json_doc, path[, path] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-search-functions.html#function_json-extract)
	- Returns data from a JSON document, selected from the parts of the document matched by the path arguments.
* [JSON_INSERT(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-insert)
	- Inserts data into a JSON document and returns the result.
* [JSON_KEYS(json_doc[, path])](https://dev.mysql.com/doc/refman/5.7/en/json-search-functions.html#function_json-keys)
	- Returns the keys from the top-level value of a JSON object as a JSON array, or, if a path argument is given, the top-level keys from the selected path.
* [JSON_LENGTH(json_doc[, path])](https://dev.mysql.com/doc/refman/5.7/en/json-attribute-functions.html#function_json-length)
	- Returns the length of JSON document, or, if a path argument is given, the length of the value within the document identified by the path.
* [JSON_MERGE(json_doc, json_doc[, json_doc] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-merge)
	- Merges two or more JSON documents and returns the merged result.
* [JSON_MERGE_PATCH(json_doc, json_doc[, json_doc] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-merge-patch)
    - Performs an RFC 7396 compliant merge of two or more JSON documents and returns the merged result.
* [JSON_OBJECT([key, val[, key, val] ...])](https://dev.mysql.com/doc/refman/5.7/en/json-creation-functions.html#function_json-object)
	- Evaluates a (possibly empty) list of key/value pairs and returns a JSON object containing those pairs.
* [JSON_PRETTY(json_val)](https://dev.mysql.com/doc/refman/5.7/en/json-utility-functions.html#function_json-pretty)
	- Provides pretty-printing of JSON values similar to that implemented in PHP and by other languages and database systems
* [JSON_QUOTE(json_val)](https://dev.mysql.com/doc/refman/5.7/en/json-creation-functions.html#function_json-quote)
	- Quotes a string as a JSON value by wrapping it with double quote characters and escaping interior quote and other characters, then returning the result as a utf8mb4 string.
* [JSON_REMOVE(json_doc, path[, path] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-remove)
	- Removes data from a JSON document and returns the result.
* [JSON_REPLACE(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-replace)
	- Replaces existing values in a JSON document and returns the result.
* [JSON_SEARCH(json_doc, one_or_all, search_str[, escape_char[, path] ...])](https://dev.mysql.com/doc/refman/5.7/en/json-search-functions.html#function_json-search)
	- Returns the path to the given string within a JSON document.
* [JSON_SET(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-set)
	- Inserts or updates data in a JSON document and returns the result.
* [JSON_TYPE(json_val)](https://dev.mysql.com/doc/refman/5.7/en/json-attribute-functions.html#function_json-type)
	- Returns a utf8mb4 string indicating the type of a JSON value.
* [JSON_UNQUOTE(val)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-unquote)
	- Unquotes JSON value and returns the result as a utf8mb4 string.
* [JSON_VALID(val)](https://dev.mysql.com/doc/refman/5.7/en/json-attribute-functions.html#function_json-valid)
	- Returns 0 or 1 to indicate whether a value is a valid JSON document.

### MariaDb 10.2.3 JSON operators
* [JSON_VALUE(json_doc, path)](https://mariadb.com/kb/en/library/json_value/)
	- Returns the scalar specified by the path. Returns NULL if there is no match.
* [JSON_EXISTS(json_doc, path)](https://mariadb.com/kb/en/library/json_exists/)
    - Determines whether a specified JSON value exists in the given data. Returns 1 if found, 0 if not, or NULL if any of the inputs were NULL.

### PostgreSQL 9.3+ JSON operators
Basic support for JSON operators is implemented. This works even with `Doctrine\DBAL` v2.5. [Official documentation of JSON operators](https://www.postgresql.org/docs/9.3/static/functions-json.html).

* **JSON_GET(jsondoc, path)**
	- expands to `jsondoc->path` in case of numeric `path` (use with JSON arrays)
	- expands to `jsondoc->'path'` in case of non-numeric `path` (use with JSON objects)

* **JSON_GET_TEXT(jsondoc, path)**
	- expands to `jsondoc->>path` in case of numeric `path` (use with JSON arrays)
	- expands to `jsondoc->>'path'` in case of non-numeric `path` (use with JSON objects)

* **JSON_GET_PATH(jsondoc, path)**
	- expands to `jsondoc#>'path'`

* **JSON_GET_PATH_TEXT(jsondoc, path)**
	- expands to `jsondoc#>>'path'`

Please note that chaining of JSON operators is not supported.

### SQLite JSON1 Extension operators

Support for all the scalar and aggregare functions as seen in the [JSON1 Extension documentation](https://www.sqlite.org/json1.html).

#### Scalar functions

* JSON(json)
    - Verifies that its argument is a valid JSON string and returns a minified version of that JSON string.
* JSON_ARRAY([val[, val] ...])
    - Accepts zero or more arguments and returns a well-formed JSON array that is composed from those arguments.
* JSON_ARRAY_LENGTH(json[, path])
    - Returns the number of elements in the JSON array `json`, or 0 if `json` is some kind of JSON value other than an array.
* JSON_EXTRACT(json, path[, path ], ...)
    - Extracts and returns one or more values from the well-formed JSON.
* JSON_INSERT(json[, path, value],...)
    - Given zero or more sets of paths and values, it inserts (without overwriting) each value at its corresponding path of the `json`.
* JSON_OBJECT(label, value[, label, value], ...)
    - Accepts zero or more pairs of arguments and returns a well-formed JSON object that is composed from those arguments.
* JSON_PATCH(target, patch)
    - Applies a `patch` to `target`.
* JSON_QUOTE(value)
    - Converts the SQL `value` (a number or a string) into its corresponding JSON representation.
* JSON_REMOVE(json[, path], ...)
    - Removes the values at each given `path`.
* JSON_REPLACE(json[, path, value],...)
    - Given zero or more sets of paths and values, it overwrites each value at its corresponding path of the `json`.
* JSON_SET(json[, path, value],...)
    - Given zero or more sets of paths and values, it inserts or overwrites each value at its corresponding path of the `json`.
* JSON_TYPE(json[, path])
    - Returns the type of the outermost element of `json` or of the value at `path`.
* JSON_VALID(json)
    - Returns 1 if the argument `json` is well-formed JSON or 0 otherwise.

#### Aggregate functions

* JSON_GROUP_ARRAY(value)
    - Returns a JSON array comprised of all `value` in the aggregation
* JSON_GROUP_OBJECT(name, value)
    - Returns a JSON object comprised of all `name/value` pairs in the aggregation.

Extendability and Database Support
----------------------------------

### Architecture

Platform function classes naming rule is:

```
Scienta\DoctrineJsonFunctions\Query\AST\Functions\$platformName\$functionName
```

### Adding a new platform

To add support of new platform you just need to create new folder `Scienta\DoctrineJsonFunctions\Query\AST\Functions\$platformName`
and implement required function there according to naming rules

### Adding a new function

If you want to add new function to this library feel free to fork it and create pull request with your implementation.
Please, remember to update documentation with your new functions.


See also
--------

[dunglas/doctrine-json-odm](https://github.com/dunglas/doctrine-json-odm): Serialize / deserialize plain old PHP objects into JSON columns.

# DoctrineJsonFunctions
A set of extensions to Doctrine 2 that add support for json query functions.

Table of Contents
-----------------

- [DQL Functions](#dql-functions)
    - [Installation](#installation)
    - [Functions Registration](#functions-registration)
        - [Doctrine2](#doctrine2)
    - [Extendability and Database Support](#extendability-and-database-support)
        - [Architecture](#architecture)
        - [Adding new platform](#adding-a-new-platform)
        - [Adding new function](#adding-a-new-function)

DQL Functions
=============

This library provide set of DQL functions.
Available Mysql functions:

* [JSON_APPEND(json_doc, path, val[, path, val] ...)](https://dev.mysql.com/doc/refman/5.7/en/json-modification-functions.html#function_json-append)
	- Appends values to the end of the indicated arrays within a JSON document and returns the result.
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
* [JSON_OBJECT([key, val[, key, val] ...])](https://dev.mysql.com/doc/refman/5.7/en/json-creation-functions.html#function_json-object)
	- Evaluates a (possibly empty) list of key/value pairs and returns a JSON object containing those pairs.
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

### PostgreSQL 9.3+ operators
Basic support for JSON operators is implemented. This works even with `Doctrine\DBAL` v2.5. [Official documentation of JSON operators](https://www.postgresql.org/docs/9.3/static/functions-json.html).

* **GT(jsondoc, path)**
	- expands to `jsondoc->path` in case of numeric `path` (use with JSON arrays)
	- expands to `jsondoc->'path'` in case of non-numeric `path` (use with JSON objects)

* **GT_GT(jsondoc, path)**
	- expands to `jsondoc->>path` in case of numeric `path` (use with JSON arrays)
	- expands to `jsondoc->>'path'` in case of non-numeric `path` (use with JSON objects)

* **SHARP_GT(jsondoc, path)**
	- expands to `jsondoc#>'path'`

* **SHARP_GT_GT(jsondoc, path)**
	- expands to `jsondoc#>>'path'`

Please note that chaining of JSON operators in not supported (PR is welcomed)!


Installation
------------

Add the following dependency to your composer.json
```json
{
	"require": {
		"syslogic/doctrine-json-functions": "dev-master"
	}
}
```

Functions Registration
----------------------

### Doctrine2

[Doctrine2 Documentation: "DQL User Defined Functions"](http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html)

```php
<?php

use Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql as DqlFunctions;

$config = new \Doctrine\ORM\Configuration();
$config->addCustomStringFunction(DqlFunctions\JsonExtract::FUNCTION_NAME, DqlFunctions\JsonExtract::class);
$config->addCustomStringFunction(DqlFunctions\JsonSearch::FUNCTION_NAME, DqlFunctions\JsonSearch::class);

$em = EntityManager::create($dbParams, $config);
$queryBuilder = $em->createQueryBuilder();
```

Usage
-----

Mind the comparison when creating the expression and escape the parameters to be valid JSON.

```php
$queryBuilder
  ->select('c')
  ->from('Customer', 'c')
  ->where("JSON_CONTAINS(c.attributes, :certificates, '$.certificates') = 1");
 
$result = $q->execute(array(
  'certificates' => '"BIO"',
));
```

### PostgreSQL 9.3+ JSON operators
```php
$queryBuilder
  ->select('c')
  ->from('Customer', 'c')
  ->where("GT_GT(c.attributes, 'gender') = :gender");
 
 $result = $q->execute(array(
    'gender' => 'male',
 ));
```



Extendability and Database Support
----------------------------------

### Architecture

Platform function classes naming rule is:

```
Syslogic\DoctrineJsonFunctions\Query\AST\Functions\$platformName\$functionName
```

### Adding a new platform

To add support of new platform you just need to create new folder `Syslogic\DoctrineJsonFunctions\Query\AST\Functions\$platformName`
and implement required function there according to naming rules

### Adding a new function

If you want to add new function to this library feel free to fork it and create pull request with your implementation.
Please, remember to update documentation with your new functions.

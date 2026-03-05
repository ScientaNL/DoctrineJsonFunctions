<?php

declare(strict_types=1);

// The #[Override] attribute was introduced in PHP 8.3. This polyfill defines
// a no-op class for PHP 8.1 and 8.2 so the attribute can be used in code
// that targets multiple PHP versions.
if (PHP_VERSION_ID < 80300) {
    #[Attribute(Attribute::TARGET_METHOD)]
    class Override
    {
    }
}

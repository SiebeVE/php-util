<?php

declare(strict_types=1);

namespace ADS\Util;

use ADS\Util\Exception\StringUtilException;

use function lcfirst;
use function preg_replace;
use function sprintf;
use function str_replace;
use function strtolower;
use function trim;
use function ucwords;

final class StringUtil
{
    public static function camelize(string $string, string $delimiter = '_', bool $pascal = false): string
    {
        $result = str_replace($delimiter, '', ucwords($string, $delimiter));

        return $pascal ? $result : lcfirst($result);
    }

    public static function decamelize(string $string, string $delimiter = '_'): string
    {
        $regex = [
            '/([a-z\d])([A-Z])/',
            sprintf('/([^%s])([A-Z][a-z])/', $delimiter),
        ];

        $replaced = preg_replace($regex, '$1_$2', $string);

        if ($replaced === null) {
            throw StringUtilException::couldNotDecamilize($string);
        }

        return strtolower($replaced);
    }

    public static function slug(string $slug): string
    {
        /** @var string $trim */
        $trim = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);

        return strtolower(trim($trim, '-'));
    }
}

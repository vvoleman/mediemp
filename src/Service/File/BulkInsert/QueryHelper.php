<?php

namespace App\Service\File\BulkInsert;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Identifier;

class QueryHelper{
    public static function sql(AbstractPlatform $platform, Identifier $table, array $dataset): string {
        $columns = self::quote_columns($platform, self::extract_columns($dataset));
        $sql = sprintf(
            'INSERT INTO %s %s VALUES %s ON DUPLICATE KEY UPDATE %s;',
            $table->getQuotedName($platform),
            self::stringify_columns($columns),
            self::generate_placeholders(count($columns), count($dataset)),
            self::get_update($columns)
        );
        return $sql;
    }

    public static function get_update(array $columns): string {
        $arr = [];
        foreach ($columns as $c) {
            $arr[] = sprintf("%s=VALUES(%s)", $c, $c);
        }
        return join(",", $arr);
    }

    public static function extract_columns(array $dataset): array {
        if (empty($dataset)) {
            return [];
        }

        $first = reset($dataset);

        return array_keys($first);
    }

    public static function quote_columns(AbstractPlatform $platform, array $columns): array {
        return array_map(static function (string $column) use ($platform): string {
            return (new Identifier($column))->getQuotedName($platform);
        }, $columns);
    }

    public static function stringify_columns(array $columns): string {
        return empty($columns) ? '' : sprintf('(%s)', implode(', ', $columns));
    }

    public static function generate_placeholders(int $columnsLength, int $datasetLength): string {
        // (?, ?, ?, ?)
        $placeholders = sprintf('(%s)', implode(', ', array_fill(0, $columnsLength, '?')));

        // (?, ?), (?, ?)
        return implode(', ', array_fill(0, $datasetLength, $placeholders));
    }

    public static function parameters(array $dataset): array {
        return array_reduce($dataset, static function (array $flattenedValues, array $dataset): array {
            return array_merge($flattenedValues, array_values($dataset));
        }, []);
    }

    public static function types(array $types, int $datasetLength): array {
        if (empty($types)) {
            return [];
        }

        $types = array_values($types);

        $positionalTypes = [];

        for ($idx = 1; $idx <= $datasetLength; $idx++) {
            $positionalTypes = array_merge($positionalTypes, $types);
        }

        return $positionalTypes;
    }
}


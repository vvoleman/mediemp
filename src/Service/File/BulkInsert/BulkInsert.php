<?php

namespace App\Service\File\BulkInsert;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Identifier;

class BulkInsert {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function execute(string $table, array $dataset, array $types = []): int {
        if (empty($dataset)) {
            return 0;
        }

        $sql = QueryHelper::sql($this->connection->getDatabasePlatform(), new Identifier($table), $dataset);
        if (method_exists($this->connection, 'executeStatement')) {
            return $this->connection->executeStatement($sql, QueryHelper::parameters($dataset), QueryHelper::types($types, count($dataset)));
        }

        return $this->connection->executeUpdate($sql, QueryHelper::parameters($dataset), QueryHelper::types($types, count($dataset)));
    }

    public function transactional(string $table, array $dataset, array $types = []): int {
        return $this->connection->transactional(function () use ($table, $dataset, $types): int {
            return $this->execute($table, $dataset, $types);
        });
    }



}
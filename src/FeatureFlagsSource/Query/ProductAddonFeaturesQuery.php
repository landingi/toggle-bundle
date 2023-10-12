<?php

declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Query;

use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

final class ProductAddonFeaturesQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchByAccountUuid(Uuid $accountUuid): array
    {
        $sql = <<<SQL
        SELECT f.name
        FROM accounts_features f
        JOIN accounts a ON IFNULL(a.agency_id, a.id) = f.account_id
        WHERE
            a.uuid = :accountUuid
        SQL;

        return $this->connection->fetchFirstColumn($sql, ['accountUuid' => (string) $accountUuid]);
    }
}

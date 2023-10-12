<?php

declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Query;

use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

final class AccountFeaturesQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchByAccountUuid(Uuid $accountUuid): array
    {
        $sql = <<<SQL
        SELECT DISTINCT(paf.feature_flag_name)
        FROM product_addons_features paf
        JOIN product_addons_accounts paa USING (product_addons_id)
        JOIN accounts a ON IFNULL(a.agency_id, a.id) = paa.account_id
        WHERE 
            a.uuid = :accountUuid
        SQL;

        return $this->connection->fetchFirstColumn($sql, ['accountUuid' => (string) $accountUuid]);
    }
}

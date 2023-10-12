<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Query;

use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

final class PackageFeaturesQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchByAccountUuid(Uuid $accountUuid): array
    {
        $sql = <<<SQL
        SELECT pf.name
        FROM package_features pf
        JOIN prefix_profile pp ON pf.package_id = pp.package_id
        JOIN accounts a ON a.profile_id = pp.id
        WHERE
            a.uuid = :accountUuid
        SQL;

        return $this->connection->fetchFirstColumn($sql, ['accountUuid' => (string) $accountUuid]);
    }
}

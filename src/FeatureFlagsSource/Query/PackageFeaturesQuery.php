<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Types\Types;
use RuntimeException;
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
        $query = $this->connection->createQueryBuilder();
        $query->select('DISTINCT(pf.name)');
        $query->from('packages_features', 'pf');
        $query->join('pf', 'prefix_profile', 'pp', 'pf.package_id = pp.package_id');
        $query->join('pp', 'accounts', 'a', 'a.profile_id = pp.id');
        $query->where('a.uuid = :account_uuid');
        $query->setParameter('account_uuid', (string) $accountUuid, Types::STRING);
        $result = $query->execute();

        if (!$result instanceof Result) {
            throw new RuntimeException('Query execution failure');
        }

        return array_map(static fn(array $item) => $item['name'], $result->fetchAllAssociative());
    }
}

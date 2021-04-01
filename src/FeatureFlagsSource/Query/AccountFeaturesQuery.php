<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Types\Types;
use RuntimeException;
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
        $query = $this->connection->createQueryBuilder();
        $query->select('f.name');
        $query->from('accounts_features', 'f');
        $query->join('f', 'accounts', 'a', 'IFNULL(a.agency_id, a.id) = f.account_id');
        $query->where('a.uuid = :account_uuid');
        $query->setParameter('account_uuid', (string) $accountUuid, Types::STRING);
        $result = $query->execute();

        if (!$result instanceof Result) {
            throw new RuntimeException('Query execution failure');
        }

        return array_map(static fn(array $item) => $item['name'], $result->fetchAllAssociative());
    }
}

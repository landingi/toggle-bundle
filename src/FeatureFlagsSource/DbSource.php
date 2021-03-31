<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Doctrine\DBAL\Connection;
use Landingi\ToggleBundle\FeatureFlagsSource\Query\AccountFeaturesQuery;
use Landingi\ToggleBundle\FeatureFlagsSource\Query\PackageFeaturesQuery;
use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class DbSource extends AbstractSource
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    protected function getFeatureFlagsFromSource(Uuid $accountUuid): array
    {
        return array_merge(
            (new AccountFeaturesQuery(
                $this->connection
            ))->fetchByAccountUuid($accountUuid),
            (new PackageFeaturesQuery(
                $this->connection
            ))->fetchByAccountUuid($accountUuid)
        );
    }
}

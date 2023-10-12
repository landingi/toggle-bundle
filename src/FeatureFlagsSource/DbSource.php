<?php

declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Landingi\ToggleBundle\FeatureFlagsSource\Query\AccountFeaturesQuery;
use Landingi\ToggleBundle\FeatureFlagsSource\Query\PackageFeaturesQuery;
use Landingi\ToggleBundle\FeatureFlagsSource\Query\ProductAddonFeaturesQuery;
use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class DbSource extends AbstractSource
{
    private AccountFeaturesQuery $accountFeaturesQuery;
    private PackageFeaturesQuery $packageFeaturesQuery;
    private ProductAddonFeaturesQuery $productAddonFeaturesQuery;

    public function __construct(
        AccountFeaturesQuery $accountFeaturesQuery,
        PackageFeaturesQuery $packageFeaturesQuery,
        ProductAddonFeaturesQuery $productAddonFeaturesQuery
    ) {
        $this->accountFeaturesQuery = $accountFeaturesQuery;
        $this->packageFeaturesQuery = $packageFeaturesQuery;
        $this->productAddonFeaturesQuery = $productAddonFeaturesQuery;
    }

    protected function getFeatureFlagsFromSource(Uuid $accountUuid): array
    {
        return array_unique(
            array_merge(
                $this->accountFeaturesQuery->fetchByAccountUuid($accountUuid),
                $this->packageFeaturesQuery->fetchByAccountUuid($accountUuid),
                $this->productAddonFeaturesQuery->fetchByAccountUuid($accountUuid),
            )
        );
    }
}

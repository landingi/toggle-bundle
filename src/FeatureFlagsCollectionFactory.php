<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle;

use Landingi\ToggleBundle\FeatureFlagsSource\FeatureFlagsSource;
use Symfony\Component\Uid\Uuid;

final class FeatureFlagsCollectionFactory
{
    private FeatureFlagsSource $featureFlagsSource;

    public function __construct(/*This should be config based*/FeatureFlagsSource $featureFlagsSource)
    {
        $this->featureFlagsSource = $featureFlagsSource;
    }

    public function create(string $accountUuid): FeatureFlagsCollection
    {
        return new FeatureFlagsCollection(...array_map(
            static fn (string $featureFlag) => new FeatureFlag($featureFlag),
            $this->featureFlagsSource->getFeatureFlags(Uuid::fromString($accountUuid))
        ));
    }
}

<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle;

final class AccessVoter
{
    private FeatureFlagsCollectionFactory $collectionFactory;

    public function __construct(FeatureFlagsCollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function vote(string $accountUuid, string $featureFlag): bool
    {
        $featureFlags = $this->collectionFactory->create($accountUuid);

        return $featureFlags->contains(new FeatureFlag($featureFlag));
    }
}

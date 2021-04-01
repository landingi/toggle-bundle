<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle;

final class FeatureFlagsCollection
{
    private array $featureFlags;

    public function __construct(FeatureFlag ...$featureFlags)
    {
        $this->featureFlags = $featureFlags;
    }

    public function contains(FeatureFlag $featureFlag): bool
    {
        return in_array($featureFlag, $this->featureFlags);
    }
}

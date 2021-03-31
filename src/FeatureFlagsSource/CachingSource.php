<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class CachingSource implements FeatureFlagsSource
{
    private FeatureFlagsSource $featureFlagsSource;
    private Cache $cache;

    public function __construct(FeatureFlagsSource $featureFlagsSource, Cache $cache)
    {
        $this->featureFlagsSource = $featureFlagsSource;
        $this->cache = $cache;
    }

    public function getFeatureFlags(Uuid $accountUuid): array
    {
        $features = $this->featureFlagsSource->getFeatureFlags($accountUuid);
        $this->cache->put($accountUuid, $features);

        return $features;
    }
}

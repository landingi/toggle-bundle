<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Symfony\Component\Uid\Uuid;

abstract class AbstractSource implements FeatureFlagsSource
{
    private ?AbstractSource $nextSource = null;

    abstract protected function getFeatureFlagsFromSource(Uuid $accountUuid): array;

    public function getFeatureFlags(Uuid $accountUuid): array
    {
        $features = $this->getFeatureFlagsFromSource($accountUuid);

        if (empty($features) && $this->nextSource) {
            return $this->nextSource->getFeatureFlags($accountUuid);
        }

        return $features;
    }

    public function addNextSource(self $nextSource): void
    {
        $this->nextSource = $nextSource;
    }
}

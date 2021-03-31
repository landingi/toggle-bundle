<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Symfony\Component\Uid\Uuid;

interface FeatureFlagsSource
{
    public function getFeatureFlags(Uuid $accountUuid): array;
}

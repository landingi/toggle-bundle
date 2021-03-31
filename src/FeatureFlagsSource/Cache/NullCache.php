<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Cache;

use Landingi\ToggleBundle\FeatureFlagsSource\Cache;
use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class NullCache implements Cache
{
    public function put(Uuid $accountUuid, array $featureFlags): void
    {
    }

    public function delete(?string $key): void
    {
    }
}

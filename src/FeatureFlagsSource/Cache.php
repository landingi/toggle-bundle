<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Symfony\Component\Uid\Uuid;

interface Cache
{
    public function put(Uuid $accountUuid, array $featureFlags): void;

    public function delete(?string $key): void;
}

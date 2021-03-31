<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Symfony\Component\Uid\Uuid;

final class RedisKeyFactory
{
    public function createFromAccountUuid(Uuid $accountUuid): string
    {
        return "ff_list_{$accountUuid->toRfc4122()}";
    }

    public function createPatternFromString(?string $key): string
    {
        if (null === $key) {
            return 'ff_list_*';
        }

        $accountUuid = Uuid::fromString($key);

        return "ff_list_{$accountUuid->toRfc4122()}";
    }
}

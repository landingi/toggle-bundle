<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource\Cache;

use Landingi\ToggleBundle\FeatureFlagsSource\Cache;
use Landingi\ToggleBundle\FeatureFlagsSource\RedisKeyFactory;
use Predis\Client;
use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class RedisCache implements Cache
{
    private Client $client;
    private RedisKeyFactory $keyFactory;
    private int $cacheTimeInSeconds;

    public function __construct(Client $client, RedisKeyFactory $keyFactory, int $cacheTimeInSeconds)
    {
        $this->client = $client;
        $this->keyFactory = $keyFactory;
        $this->cacheTimeInSeconds = $cacheTimeInSeconds;
    }

    public function put(Uuid $accountUuid, array $featureFlags): void
    {
        if (empty($featureFlags)) {
            return;
        }

        $key = $this->keyFactory->createFromAccountUuid($accountUuid);
        $this->client->hmset($key, $featureFlags);
        $this->client->expire($key, $this->cacheTimeInSeconds);
    }

    public function delete(?string $key): void
    {
        $keys = $this->client->keys(
            $this->keyFactory->createPatternFromString($key)
        );

        if (empty($keys)) {
            return;
        }

        $this->client->del($keys);
    }
}

<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\FeatureFlagsSource;

use Predis\Client;
use Symfony\Component\Uid\Uuid;

/**
 * @codeCoverageIgnore
 */
final class RedisSource extends AbstractSource
{
    private Client $client;
    private RedisKeyFactory $keyFactory;

    public function __construct(Client $client, RedisKeyFactory $keyFactory)
    {
        $this->client = $client;
        $this->keyFactory = $keyFactory;
    }

    protected function getFeatureFlagsFromSource(Uuid $accountUuid): array
    {
        return $this->client->hgetall(
            $this->keyFactory->createFromAccountUuid(
                $accountUuid
            )
        );
    }
}

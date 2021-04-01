<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\DependencyInjection;

use Landingi\ToggleBundle\FeatureFlagsCollectionFactory;
use Landingi\ToggleBundle\FeatureFlagsSource\Cache\RedisCache;
use Landingi\ToggleBundle\FeatureFlagsSource\CachingSource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class LandingiToggleExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        if ($mergedConfig['cache']['enabled']) {
            $this->configureRedisCache($container, (int) $mergedConfig['cache']['ttl']);
            $this->configureRedisConnection($container, $mergedConfig['cache']['redis_connection']);
            $this->configureFeatureFlagsCollection($container);
        }
    }

    protected function configureRedisCache(ContainerBuilder $container, int $ttl): void
    {
        $redisCache = $container->getDefinition(RedisCache::class);
        $redisCache->replaceArgument(2, $ttl);
    }

    protected function configureRedisConnection(ContainerBuilder $container, array $redisConnection): void
    {
        $container->setParameter('landingi_toggle_redis_connection', $redisConnection);
    }

    protected function configureFeatureFlagsCollection(ContainerBuilder $container): void
    {
        $featureFlagsCollectionDefinition = $container->getDefinition(FeatureFlagsCollectionFactory::class);
        $featureFlagsCollectionDefinition->replaceArgument(0, $container->getDefinition(CachingSource::class));
    }
}

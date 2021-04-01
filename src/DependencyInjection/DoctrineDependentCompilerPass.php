<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\DependencyInjection;

use InvalidArgumentException;
use Landingi\ToggleBundle\FeatureFlagsSource\DbSource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DoctrineDependentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getExtensionConfig('landingi_toggle')[0];

        if (empty($config['dbal']['connection_name'])) {
            throw new InvalidArgumentException('Dbal connection name must be provided in te configuration of toggle-bundle');
        }

        $availableConnectionNames = $container->getParameter('doctrine.connections');
        $connectionName = sprintf('doctrine.dbal.%s_connection', $config['dbal']['connection_name']);

        if (false === in_array($connectionName, array_values($availableConnectionNames), true)) {
            throw new InvalidArgumentException('Dbal connection name not exists, check configuration of toggle-bundle or doctrine');
        }

        $dbSourceDefinition = $container->getDefinition(DbSource::class);
        $dbSourceDefinition->setArgument(0, $container->getDefinition($connectionName));
    }
}

<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle;

use Landingi\ToggleBundle\DependencyInjection\DoctrineDependentCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LandingiToggleBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DoctrineDependentCompilerPass());
    }
}

<?php
declare(strict_types=1);

namespace Landingi\Tests\ToggleBundle\Unit\Voter;

use Landingi\ToggleBundle\FeatureFlag;
use PHPUnit\Framework\TestCase;

class FeatureFlagTest extends TestCase
{
    public function testProperlyConstructing(): void
    {
        $featureFlag = new FeatureFlag('FOO');

        self::assertEquals('FOO', $featureFlag->getName());
    }
}

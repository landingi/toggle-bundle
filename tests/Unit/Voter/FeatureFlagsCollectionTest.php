<?php
declare(strict_types=1);

namespace Landingi\Tests\ToggleBundle\Unit\Voter;

use Landingi\ToggleBundle\FeatureFlag;
use Landingi\ToggleBundle\FeatureFlagsCollection;
use PHPUnit\Framework\TestCase;

class FeatureFlagsCollectionTest extends TestCase
{
    public function testContains(): void
    {
        $features = new FeatureFlagsCollection(
            new FeatureFlag('FOO'),
            new FeatureFlag('BAR'),
        );
        self::assertTrue(
            $features->contains(
                new FeatureFlag('FOO')
            )
        );
        self::assertTrue(
            $features->contains(
                new FeatureFlag('BAR')
            )
        );
        self::assertFalse(
            $features->contains(
                new FeatureFlag('BAZ')
            )
        );
    }
}

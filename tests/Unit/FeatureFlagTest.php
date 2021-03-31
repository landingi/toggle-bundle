<?php
declare(strict_types=1);

namespace Landingi\Tests\ToggleBundle\Unit;

use Landingi\ToggleBundle\FeatureFlag;
use PHPUnit\Framework\TestCase;

class FeatureFlagTest extends TestCase
{
    public function testToString(): void
    {
        self::assertEquals(
            'Foo',
            (string) new FeatureFlag('Foo')
        );
    }
}

<?php
declare(strict_types=1);

namespace Landingi\Tests\ToggleBundle\Unit\FeatureFlagsSource;

use InvalidArgumentException;
use Landingi\ToggleBundle\FeatureFlagsSource\RedisKeyFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class RedisKeyFactoryTest extends TestCase
{
    public function testCreateFromAccountUuid(): void
    {
        self::assertEquals(
            'ff_list_724222bb-fde5-4ea0-adca-aa45a08b7817',
            (new RedisKeyFactory())->createFromAccountUuid(
                Uuid::fromString(
                    '724222bb-fde5-4ea0-adca-aa45a08b7817'
                )
            )
        );
    }

    public function testCreatePatternFromEmptyString(): void
    {
        self::assertEquals(
            'ff_list_*',
            (new RedisKeyFactory())->createPatternFromString(null)
        );
    }

    public function testCreatePatternFromAccountUuidString(): void
    {
        self::assertEquals(
            'ff_list_724222bb-fde5-4ea0-adca-aa45a08b7817',
            (new RedisKeyFactory())->createPatternFromString('724222bb-fde5-4ea0-adca-aa45a08b7817')
        );
    }

    public function testItThrowsExceptionIfAccountUuidIsInvalid(): void
    {
        $this->expectExceptionObject(
            new InvalidArgumentException(
                'Invalid UUID: "foo".'
            )
        );
        (new RedisKeyFactory())->createPatternFromString('foo');
    }
}

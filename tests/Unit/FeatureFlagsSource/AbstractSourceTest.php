<?php
declare(strict_types=1);

namespace Landingi\Tests\ToggleBundle\Unit\FeatureFlagsSource;

use Landingi\ToggleBundle\FeatureFlagsSource\AbstractSource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class AbstractSourceTest extends TestCase
{
    public function test_GetUserRoleWithAccountRole_ProperlyChainingSources(): void
    {
        $chainedExpectedResult = ['LP_GROUPS'];
        $baseSource = new class() extends AbstractSource {
            protected function getFeatureFlagsFromSource(Uuid $accountUuid): array
            {
                return [];
            }
        };
        $nextChainedSource = new class($chainedExpectedResult) extends AbstractSource {
            private array $result;

            public function __construct(array $result)
            {
                $this->result = $result;
            }

            protected function getFeatureFlagsFromSource(Uuid $accountUuid): array
            {
                return $this->result;
            }
        };
        $baseSource->addNextSource($nextChainedSource);

        self::assertEquals($chainedExpectedResult, $baseSource->getFeatureFlags(
            Uuid::fromString('32a38015-4030-4fc6-a3a1-a19fe482b983')
        ));
    }
}

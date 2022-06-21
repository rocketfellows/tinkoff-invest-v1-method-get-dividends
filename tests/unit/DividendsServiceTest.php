<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\tests\unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsRequestInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsService;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

/**
 * @group services
 */
class DividendsServiceTest extends TestCase
{
    private const FIGI_TEST_VALUE = 'figi';

    /**
     * @var DividendsService
     */
    private $dividendsService;

    /**
     * @var DividendsRequestInterface|MockObject
     */
    private $dividendsRequestInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dividendsRequestInterface = $this->createMock(DividendsRequestInterface::class);

        $this->dividendsService = new DividendsService($this->dividendsRequestInterface);
    }

    public function testSuccessGetAll(): void
    {
        $dividends = $this->getTestDividends();
        $this->assertDividendsRequestAll(self::FIGI_TEST_VALUE, $dividends);

        $this->assertEqualsCanonicalizing($dividends, $this->dividendsService->getAll(self::FIGI_TEST_VALUE));
    }

    private function assertDividendsRequestAll(string $figi, Dividends $dividends): void
    {
        $this->dividendsRequestInterface
            ->expects($this->once())
            ->method('requestAll')
            ->with($figi)
            ->willReturn($dividends);
    }

    private function getTestDividends(): Dividends
    {
        return new Dividends(
            $this->createMock(Dividend::class),
            $this->createMock(Dividend::class),
            $this->createMock(Dividend::class)
        );
    }
}

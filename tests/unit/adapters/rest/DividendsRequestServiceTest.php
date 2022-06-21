<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\tests\unit\adapters\rest;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\TinkoffInvestV1InstrumentsRestClient\GetDividendsInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\adapters\rest\DividendsRequestService;
use rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsRequestInterface;

/**
 * @group adapters-rest
 */
class DividendsRequestServiceTest extends TestCase
{
    private const IMPLEMENTING_INTERFACES = [
        DividendsRequestInterface::class,
    ];

    /**
     * @var DividendsRequestService
     */
    private $dividendsRequestService;

    /**
     * @var GetDividendsInterface|MockObject
     */
    private $dividendsRequestClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dividendsRequestClient = $this->createMock(GetDividendsInterface::class);

        $this->dividendsRequestService = new DividendsRequestService($this->dividendsRequestClient);
    }

    public function testImplementations(): void
    {
        $actualInterfaceImplementations = class_implements(get_class($this->dividendsRequestService));

        foreach (self::IMPLEMENTING_INTERFACES as $implementedInterface) {
            $this->assertArrayHasKey(
                $implementedInterface,
                $actualInterfaceImplementations,
                sprintf('Implementation of %s not found', $implementedInterface)
            );
        }
    }
}

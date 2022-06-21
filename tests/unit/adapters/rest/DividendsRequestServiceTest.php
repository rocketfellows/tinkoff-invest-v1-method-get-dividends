<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\tests\unit\adapters\rest;

use arslanimamutdinov\ISOStandard4217\ISO4217;
use DateTime;
use Exception;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;
use rocketfellows\TinkoffInvestV1Common\models\Quotation;
use rocketfellows\TinkoffInvestV1InstrumentsRestClient\GetDividendsInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\adapters\rest\DividendsRequestService;
use rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsRequestInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\BadResponseData;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\ClientException;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\HttpClientException;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\ServerException;

/**
 * @group adapters-rest
 */
class DividendsRequestServiceTest extends TestCase
{
    private const FIGI_TEST_VALUE = 'figi_value';

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

    /**
     * @dataProvider getRawDividendsData
     */
    public function testSuccessRequestAll(array $rawDividendsData, Dividends $expectedDividends): void
    {
        $this->assertRequestAllDividends(self::FIGI_TEST_VALUE, $rawDividendsData);
        $this->assertEqualsCanonicalizing($expectedDividends, $this->dividendsRequestService->requestAll(self::FIGI_TEST_VALUE));
    }

    /**
     * @dataProvider getHandlingClientExceptionsProvidedData
     */
    public function testClientThrowsException(Exception $thrownClientException, string $expectedThrownExceptionClass): void
    {
        $this->assertClientThrowsException($thrownClientException);
        $this->expectException($expectedThrownExceptionClass);

        $this->dividendsRequestService->requestAll(self::FIGI_TEST_VALUE);
    }

    public function getRawDividendsData(): array
    {
        return [
            [
                'rawDividendsData' => [
                    'dividends' => [
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 530000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                    ],
                ],
                'expectedDividends' => new Dividends(
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 530000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        null,
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        '',
                        ''
                    )
                ),
            ],
            [
                'rawDividendsData' => [
                    'dividends' => [
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 530000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "foo",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "bar",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                    ],
                ],
                'expectedDividends' => new Dividends(
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 530000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        null,
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        'foo',
                        'bar'
                    )
                ),
            ],
            [
                'rawDividendsData' => [
                    'dividends' => [
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 530000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "paymentDate" => "2021-08-19T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "foo",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "bar",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                    ],
                ],
                'expectedDividends' => new Dividends(
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 530000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        new DateTime('2021-08-19T00:00:00Z'),
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        'foo',
                        'bar'
                    )
                ),
            ],
            [
                'rawDividendsData' => [
                    'dividends' => [
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 530000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "paymentDate" => "2021-08-19T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "foo",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "bar",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 520000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "paymentDate" => "2021-08-19T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "foo",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "bar",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                        [
                            'dividendNet' => [
                                'currency' => 'rub',
                                'units' => '52',
                                'nano' => 520000000,
                            ],
                            "declaredDate" => "2022-06-30T00:00:00Z",
                            "paymentDate" => "2021-08-19T00:00:00Z",
                            "lastBuyDate" => "2022-07-18T00:00:00Z",
                            "dividendType" => "foo",
                            "recordDate" => "2022-07-20T00:00:00Z",
                            "regularity" => "bar",
                            "closePrice" => [
                                "currency" => "rub",
                                "units" => "315",
                                "nano" => 500000000,
                            ],
                            "yieldValue" => [
                                "units" => "16",
                                "nano" => 650000000
                            ],
                            "createdAt" => "2022-06-20T02:05:31.133407Z",
                        ],
                    ],
                ],
                'expectedDividends' => new Dividends(
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 530000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        new DateTime('2021-08-19T00:00:00Z'),
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        'foo',
                        'bar'
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 520000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        new DateTime('2021-08-19T00:00:00Z'),
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        'foo',
                        'bar'
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 52, 520000000),
                        new MoneyValue(ISO4217::RUB(), 315, 500000000),
                        new Quotation(16, 650000000),
                        new DateTime('2021-08-19T00:00:00Z'),
                        new DateTime('2022-06-30T00:00:00Z'),
                        new DateTime('2022-07-18T00:00:00Z'),
                        new DateTime('2022-07-20T00:00:00Z'),
                        new DateTime('2022-06-20T02:05:31.133407Z'),
                        'foo',
                        'bar'
                    ),
                ),
            ],
        ];
    }

    public function getHandlingClientExceptionsProvidedData(): array
    {
        return [
            [
                'thrownClientException' => new HttpClientException(),
                'expectedThrownExceptionClass' => SourceFaultException::class,
            ],
            [
                'thrownClientException' => new ClientException(new BadResponseData()),
                'expectedThrownExceptionClass' => IncorrectInputsException::class,
            ],
            [
                'thrownClientException' => new ServerException(new BadResponseData()),
                'expectedThrownExceptionClass' => SourceFaultException::class,
            ],
        ];
    }

    private function assertClientThrowsException(Exception $exception): void
    {
        $this->dividendsRequestClient->method('getDividends')->willThrowException($exception);
    }

    private function assertRequestAllDividends(string $figi, array $rawDividendsData): void
    {
        $this->expectsDividendsRequest()->with(['figi' => $figi])->willReturn($rawDividendsData);
    }

    private function expectsDividendsRequest(): InvocationMocker
    {
        return $this->dividendsRequestClient->expects($this->once())->method('getDividends');
    }
}

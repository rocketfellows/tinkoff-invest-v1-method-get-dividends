<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\tests\unit\models;

use arslanimamutdinov\ISOStandard4217\ISO4217;
use DateTime;
use PHPUnit\Framework\TestCase;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;
use rocketfellows\TinkoffInvestV1Common\models\Quotation;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

/**
 * @group models
 */
class DividendsTest extends TestCase
{
    public function testEmptyInitialization(): void
    {
        $dividends = new Dividends();

        $this->assertEquals(0, $dividends->count());
        $this->assertTrue($dividends->isEmpty());
    }

    /**
     * @dataProvider getDividendsProvidedData
     */
    public function testInitializationFromArray(array $expectedDividendsArray): void
    {
        $actualDividends = new Dividends(...$expectedDividendsArray);

        $this->assertEquals(count($expectedDividendsArray), $actualDividends->count());
        $this->assertFalse($actualDividends->isEmpty());

        $actualDividendsArray = [];

        foreach ($actualDividends as $actualDividend) {
            $actualDividendsArray[] = $actualDividend;
        }

        $this->assertEquals($expectedDividendsArray, $actualDividendsArray);
    }

    public function getDividendsProvidedData(): array
    {
        return [
            [
                'dividends' => [
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 1, 1),
                        new MoneyValue(ISO4217::RUB(), 2, 2),
                        new Quotation(3, 4),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                ],
            ],
            [
                'dividends' => [
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 1, 1),
                        new MoneyValue(ISO4217::RUB(), 2, 2),
                        new Quotation(3, 4),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 22, 22),
                        new MoneyValue(ISO4217::RUB(), 3113, 1313),
                        new Quotation(123, 31212),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                ],
            ],
            [
                'dividends' => [
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 1, 1),
                        new MoneyValue(ISO4217::RUB(), 2, 2),
                        new Quotation(3, 4),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 22, 22),
                        new MoneyValue(ISO4217::RUB(), 3113, 1313),
                        new Quotation(123, 31212),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 123123, 123),
                        new MoneyValue(ISO4217::RUB(), 2323, 2323),
                        new Quotation(2323, 2323),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                    new Dividend(
                        new MoneyValue(ISO4217::RUB(), 222, 222),
                        new MoneyValue(ISO4217::RUB(), 31213, 13213),
                        new Quotation(1223, 312122),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        new DateTime(),
                        "",
                        ""
                    ),
                ],
            ],
        ];
    }
}

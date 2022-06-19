<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\tests\unit\models;

use arslanimamutdinov\ISOStandard4217\ISO4217;
use DateTime;
use PHPStan\Testing\TestCase;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;
use rocketfellows\TinkoffInvestV1Common\models\Quotation;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend;

/**
 * @group models
 */
class DividendTest extends TestCase
{
    /**
     * @dataProvider getDividendProvidedData
     */
    public function testSuccessInitialization(
        MoneyValue $dividendNet,
        MoneyValue $closePrice,
        Quotation $yieldValue,
        DateTime $paymentDate,
        DateTime $declaredDate,
        DateTime $lastBuyDate,
        DateTime $recordDate,
        DateTime $createdAt,
        ?string $dividendType,
        ?string $regularity
    ): void {
        $actualDividend = new Dividend(
            $dividendNet,
            $closePrice,
            $yieldValue,
            $paymentDate,
            $declaredDate,
            $lastBuyDate,
            $recordDate,
            $createdAt,
            $dividendType,
            $regularity
        );

        $this->assertEquals($dividendNet, $actualDividend->getDividendNet());
        $this->assertEquals($closePrice, $actualDividend->getClosePrice());
        $this->assertEquals($yieldValue, $actualDividend->getYieldValue());
        $this->assertEquals($paymentDate, $actualDividend->getPaymentDate());
        $this->assertEquals($declaredDate, $actualDividend->getDeclaredDate());
        $this->assertEquals($lastBuyDate, $actualDividend->getLastBuyDate());
        $this->assertEquals($recordDate, $actualDividend->getRecordDate());
        $this->assertEquals($createdAt, $actualDividend->getCreatedAt());
        $this->assertEquals($dividendType, $actualDividend->getDividendType());
        $this->assertEquals($regularity, $actualDividend->getRegularity());
    }

    public function getDividendProvidedData(): array
    {
        return [
            [
                'dividendNet' => new MoneyValue(ISO4217::RUB(), 1, 1),
                'closePrice' => new MoneyValue(ISO4217::RUB(), 2, 2),
                'yieldValue' => new Quotation(3, 4),
                'paymentDate' => new DateTime(),
                'declaredDate' => new DateTime(),
                'lastBuyDate' => new DateTime(),
                'recordDate' => new DateTime(),
                'createdAt' => new DateTime(),
                'dividendType' => "",
                'regularity' => "",
            ],
            [
                'dividendNet' => new MoneyValue(ISO4217::RUB(), 1, 1),
                'closePrice' => new MoneyValue(ISO4217::RUB(), 2, 2),
                'yieldValue' => new Quotation(3, 4),
                'paymentDate' => new DateTime(),
                'declaredDate' => new DateTime(),
                'lastBuyDate' => new DateTime(),
                'recordDate' => new DateTime(),
                'createdAt' => new DateTime(),
                'dividendType' => null,
                'regularity' => null,
            ],
        ];
    }
}

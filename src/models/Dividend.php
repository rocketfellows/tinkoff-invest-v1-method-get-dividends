<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;
use rocketfellows\TinkoffInvestV1Common\models\Quotation;

class Dividend
{
    private $dividendNet;
    private $paymentDate;
    private $yieldValue;
    private $declaredDate;
    private $lastBuyDate;
    private $recordDate;
    private $closePrice;

    public function __construct(
        MoneyValue $dividendNet,
        MoneyValue $closePrice,
        Quotation $yieldValue,
        DateTime $paymentDate,
        DateTime $declaredDate,
        DateTime $lastBuyDate,
        DateTime $recordDate
    ) {
        $this->dividendNet = $dividendNet;
        $this->closePrice = $closePrice;
        $this->yieldValue = $yieldValue;
        $this->paymentDate = $paymentDate;
        $this->declaredDate = $declaredDate;
        $this->lastBuyDate = $lastBuyDate;
        $this->recordDate = $recordDate;
    }

    public function getDividendNet(): MoneyValue
    {
        return $this->dividendNet;
    }

    public function getPaymentDate(): DateTime
    {
        return $this->paymentDate;
    }

    public function getDeclaredDate(): DateTime
    {
        return $this->declaredDate;
    }

    public function getLastBuyDate(): DateTime
    {
        return $this->lastBuyDate;
    }

    public function getRecordDate(): DateTime
    {
        return $this->recordDate;
    }

    public function getClosePrice(): MoneyValue
    {
        return $this->closePrice;
    }

    public function getYieldValue(): Quotation
    {
        return $this->yieldValue;
    }
}

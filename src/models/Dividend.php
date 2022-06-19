<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;

class Dividend
{
    private $dividendNet;
    private $paymentDate;
    private $declaredDate;
    private $lastBuyDate;
    private $recordDate;

    public function __construct(
        MoneyValue $dividendNet,
        DateTime $paymentDate,
        DateTime $declaredDate,
        DateTime $lastBuyDate,
        DateTime $recordDate
    ) {
        $this->dividendNet = $dividendNet;
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
}

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

    public function __construct(
        MoneyValue $dividendNet,
        DateTime $paymentDate,
        DateTime $declaredDate,
        DateTime $lastBuyDate
    ) {
        $this->dividendNet = $dividendNet;
        $this->paymentDate = $paymentDate;
        $this->declaredDate = $declaredDate;
        $this->lastBuyDate = $lastBuyDate;
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
}

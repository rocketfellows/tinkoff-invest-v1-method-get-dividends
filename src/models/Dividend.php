<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;

class Dividend
{
    private $dividendNet;
    private $paymentDate;
    private $declaredDate;

    public function __construct(
        MoneyValue $dividendNet,
        DateTime $paymentDate,
        DateTime $declaredDate
    ) {
        $this->dividendNet = $dividendNet;
        $this->paymentDate = $paymentDate;
        $this->declaredDate = $declaredDate;
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
}

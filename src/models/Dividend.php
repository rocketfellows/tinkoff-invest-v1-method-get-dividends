<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;

class Dividend
{
    private $dividendNet;
    private $paymentDate;

    public function __construct(
        MoneyValue $dividendNet,
        DateTime $paymentDate
    ) {
        $this->dividendNet = $dividendNet;
        $this->paymentDate = $paymentDate;
    }

    public function getDividendNet(): MoneyValue
    {
        return $this->dividendNet;
    }

    public function getPaymentDate(): DateTime
    {
        return $this->paymentDate;
    }
}

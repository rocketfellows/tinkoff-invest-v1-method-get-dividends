<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;

class Dividend
{
    private $dividendNet;

    public function __construct(MoneyValue $dividendNet)
    {
        $this->dividendNet = $dividendNet;
    }

    public function getDividendNet(): MoneyValue
    {
        return $this->dividendNet;
    }
}

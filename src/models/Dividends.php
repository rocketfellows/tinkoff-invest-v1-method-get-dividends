<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\models;

use rocketfellows\tuple\Tuple;

class Dividends extends Tuple
{
    public function __construct(Dividend ...$items)
    {
        parent::__construct(...$items);
    }

    public function current(): ?Dividend
    {
        return parent::current();
    }
}

<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

class DividendsService
{
    private $dividendsRequestInterface;

    public function __construct(DividendsRequestInterface $dividendsRequestInterface)
    {
        $this->dividendsRequestInterface = $dividendsRequestInterface;
    }
}

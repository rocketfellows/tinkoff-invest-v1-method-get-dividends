<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

class DividendsService
{
    private $dividendsRequestInterface;

    public function __construct(DividendsRequestInterface $dividendsRequestInterface)
    {
        $this->dividendsRequestInterface = $dividendsRequestInterface;
    }

    /**
     * @throws SourceFaultException
     * @throws IncorrectInputsException
     */
    public function getAll(string $figi): Dividends
    {
        return $this->dividendsRequestInterface->requestAll($figi);
    }
}

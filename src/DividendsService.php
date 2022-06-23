<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

use DateTime;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

/**
 * TODO: implement other functions
 */
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

    /**
     * @throws SourceFaultException
     * @throws IncorrectInputsException
     */
    public function getBeforeDate(string $figi, DateTime $dateTime): Dividends
    {
        return $this->dividendsRequestInterface->requestToDate($figi, $dateTime);
    }
}

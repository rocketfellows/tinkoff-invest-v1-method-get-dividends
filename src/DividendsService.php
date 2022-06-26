<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\exceptions\faults\IncorrectInputsFaultException;
use rocketfellows\TinkoffInvestV1Common\exceptions\faults\SourceFaultException;
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
     * @throws IncorrectInputsFaultException
     */
    public function getAll(string $figi): Dividends
    {
        return $this->dividendsRequestInterface->requestAll($figi);
    }

    /**
     * @throws SourceFaultException
     * @throws IncorrectInputsFaultException
     */
    public function getBeforeDate(string $figi, DateTime $dateTime): Dividends
    {
        return $this->dividendsRequestInterface->requestToDate($figi, $dateTime);
    }

    /**
     * @throws IncorrectInputsFaultException
     * @throws SourceFaultException
     */
    public function getByPeriod(string $figi, DateTime $fromDateTime, DateTime $toDateTime): Dividends
    {
        return $this->dividendsRequestInterface->requestByPeriod($figi, $fromDateTime, $toDateTime);
    }
}

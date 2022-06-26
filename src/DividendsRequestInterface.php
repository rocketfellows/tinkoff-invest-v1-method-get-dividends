<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

use DateTime;
use rocketfellows\TinkoffInvestV1Common\exceptions\faults\IncorrectInputsFaultException;
use rocketfellows\TinkoffInvestV1Common\exceptions\faults\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

interface DividendsRequestInterface
{
    /**
     * @throws IncorrectInputsFaultException
     * @throws SourceFaultException
     */
    public function requestAll(string $figi): Dividends;

    /**
     * @throws IncorrectInputsFaultException
     * @throws SourceFaultException
     */
    public function requestToDate(string $figi, DateTime $toDateTime): Dividends;

    /**
     * @throws IncorrectInputsFaultException
     * @throws SourceFaultException
     */
    public function requestByPeriod(string $figi, DateTime $fromDateTime, DateTime $toDateTime): Dividends;
}

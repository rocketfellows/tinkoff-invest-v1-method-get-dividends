<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends;

use DateTime;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;

interface DividendsRequestInterface
{
    /**
     * @throws IncorrectInputsException
     * @throws SourceFaultException
     */
    public function requestAll(string $figi): Dividends;

    /**
     * @throws IncorrectInputsException
     * @throws SourceFaultException
     */
    public function requestToDate(string $figi, DateTime $toDateTime): Dividends;

    /**
     * @throws IncorrectInputsException
     * @throws SourceFaultException
     */
    public function requestByPeriod(string $figi, DateTime $fromDateTime, DateTime $toDateTime): Dividends;
}

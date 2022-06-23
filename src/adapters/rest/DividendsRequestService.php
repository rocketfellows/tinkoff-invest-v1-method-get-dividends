<?php

namespace rocketfellows\TinkoffInvestV1MethodGetDividends\adapters\rest;

use arslanimamutdinov\ISOStandard4217\ISO4217;
use DateTime;
use rocketfellows\TinkoffInvestV1Common\models\MoneyValue;
use rocketfellows\TinkoffInvestV1Common\models\Quotation;
use rocketfellows\TinkoffInvestV1InstrumentsRestClient\GetDividendsInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsRequestInterface;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend;
use rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\ClientException;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\HttpClientException;
use rocketfellows\TinkoffInvestV1RestClient\exceptions\request\ServerException;

class DividendsRequestService implements DividendsRequestInterface
{
    private const REQUEST_DATA_KEY_FIGI = 'figi';
    private const REQUEST_DATA_KEY_FROM = 'from';
    private const REQUEST_DATA_KEY_TO = 'to';

    private const RAW_DATA_KEY_DIVIDENDS_LIST = 'dividends';
    private const RAW_DATA_KEY_DIVIDEND_NET = 'dividendNet';
    private const RAW_DATA_KEY_CURRENCY = 'currency';
    private const RAW_DATA_KEY_UNITS = 'units';
    private const RAW_DATA_KEY_NANO = 'nano';
    private const RAW_DATA_KEY_DECLARED_DATE = 'declaredDate';
    private const RAW_DATA_KEY_PAYMENT_DATE = 'paymentDate';
    private const RAW_DATA_KEY_LAST_BUY_DATE = 'lastBuyDate';
    private const RAW_DATA_KEY_RECORD_DATE = 'recordDate';
    private const RAW_DATA_KEY_REGULARITY = 'regularity';
    private const RAW_DATA_KEY_CLOSE_PRICE = 'closePrice';
    private const RAW_DATA_KEY_YIELD_VALUE = 'yieldValue';
    private const RAW_DATA_KEY_DIVIDEND_TYPE = 'dividendType';
    private const RAW_DATA_KEY_CREATED_AT = 'createdAt';

    private const DATE_TIME_STRING_FORMAT = 'Y-m-d\TH:i:s.000\Z';

    private $dividendsRequestClient;

    public function __construct(GetDividendsInterface $dividendsRequestClient)
    {
        $this->dividendsRequestClient = $dividendsRequestClient;
    }

    public function requestAll(string $figi): Dividends
    {
        return $this->request([self::REQUEST_DATA_KEY_FIGI => $figi]);
    }

    public function requestToDate(string $figi, DateTime $toDateTime): Dividends
    {
        return $this->request([
            self::REQUEST_DATA_KEY_FIGI => $figi,
            self::REQUEST_DATA_KEY_TO => $toDateTime->format(self::DATE_TIME_STRING_FORMAT)
        ]);
    }

    public function requestByPeriod(string $figi, DateTime $fromDateTime, DateTime $toDateTime): Dividends
    {
        return $this->request([
            self::REQUEST_DATA_KEY_FIGI => $figi,
            self::REQUEST_DATA_KEY_FROM => $fromDateTime->format(self::DATE_TIME_STRING_FORMAT),
            self::REQUEST_DATA_KEY_TO => $toDateTime->format(self::DATE_TIME_STRING_FORMAT),
        ]);
    }

    /**
     * @throws SourceFaultException
     * @throws IncorrectInputsException
     */
    private function request(array $requestData): Dividends
    {
        try {
            return $this->createDividendsFromRawData(
                $this->dividendsRequestClient->getDividends($requestData)[self::RAW_DATA_KEY_DIVIDENDS_LIST] ?? []
            );
        } catch (ClientException $exception) {
            throw new IncorrectInputsException($exception->getErrorMessage(), $exception->getCode(), $exception);
        } catch (ServerException $exception) {
            throw new SourceFaultException($exception->getErrorMessage(), $exception->getCode(), $exception);
        } catch (HttpClientException $exception) {
            throw new SourceFaultException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function createDividendsFromRawData(array $rawDividendsData): Dividends
    {
        return new Dividends(
            ...array_map(
                static function (array $rawDividendData): Dividend {
                    return new Dividend(
                        new MoneyValue(
                            ISO4217::getByAlpha3(
                                strtoupper($rawDividendData[self::RAW_DATA_KEY_DIVIDEND_NET][self::RAW_DATA_KEY_CURRENCY])
                            ),
                            $rawDividendData[self::RAW_DATA_KEY_DIVIDEND_NET][self::RAW_DATA_KEY_UNITS],
                            $rawDividendData[self::RAW_DATA_KEY_DIVIDEND_NET][self::RAW_DATA_KEY_NANO]
                        ),
                        new MoneyValue(
                            ISO4217::getByAlpha3(
                                strtoupper($rawDividendData[self::RAW_DATA_KEY_CLOSE_PRICE][self::RAW_DATA_KEY_CURRENCY])
                            ),
                            $rawDividendData[self::RAW_DATA_KEY_CLOSE_PRICE][self::RAW_DATA_KEY_UNITS],
                            $rawDividendData[self::RAW_DATA_KEY_CLOSE_PRICE][self::RAW_DATA_KEY_NANO]
                        ),
                        new Quotation(
                            $rawDividendData[self::RAW_DATA_KEY_YIELD_VALUE][self::RAW_DATA_KEY_UNITS],
                            $rawDividendData[self::RAW_DATA_KEY_YIELD_VALUE][self::RAW_DATA_KEY_NANO]
                        ),
                        !empty($rawDividendData[self::RAW_DATA_KEY_PAYMENT_DATE]) ?
                            new DateTime($rawDividendData[self::RAW_DATA_KEY_PAYMENT_DATE]) : null,
                        new DateTime($rawDividendData[self::RAW_DATA_KEY_DECLARED_DATE]),
                        new DateTime($rawDividendData[self::RAW_DATA_KEY_LAST_BUY_DATE]),
                        new DateTime($rawDividendData[self::RAW_DATA_KEY_RECORD_DATE]),
                        new DateTime($rawDividendData[self::RAW_DATA_KEY_CREATED_AT]),
                        $rawDividendData[self::RAW_DATA_KEY_DIVIDEND_TYPE],
                        $rawDividendData[self::RAW_DATA_KEY_REGULARITY]
                    );
                },
                $rawDividendsData
            )
        );
    }
}

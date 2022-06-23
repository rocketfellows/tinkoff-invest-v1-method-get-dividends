# Tinkoff Invest V1 instruments service get dividends method

![Code Coverage Badge](./badge.svg)

Wrapper over the method for receiving dividend payment events for an instrument.

Provides a set of functions to receive dividends for a different set of query parameters.

Tinkoff swagger difinition https://tinkoff.github.io/investAPI/swagger-ui/#/InstrumentsService/InstrumentsService_GetDividends

## Component content

The component consists of two basic parts:
- *rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsService* - direct destination service to get list of dividends for an instrument
- *adapters* - adapters that implement a way to receive dividends for an instrument

## DividendsService

*DividendsService* - service provides functions for requesting a list of instrument dividends.

List of functions and their contract:
- *getAll* - takes figi value of the instrument as an input parameter, returns *Dividends* tuple, throws *SourceFaultException* and *IncorrectInputsException*
- *getBeforeDate* - as input parameters, it takes figi value of the instrument and the date of fixing the register (record_date) up to which, inclusive, it is necessary to carry out the search, returns *Dividends* tuple, throws *SourceFaultException* and *IncorrectInputsException*
- *getByPeriod* - as input parameters, it takes figi value of the instrument and the range of registry fixing dates in the interval of which it is necessary to search, returns *Dividends* tuple, throws *SourceFaultException* and *IncorrectInputsException*

```php
/**
 * @throws SourceFaultException
 * @throws IncorrectInputsException
 */
public function getAll(string $figi): Dividends;

/**
 * @throws SourceFaultException
 * @throws IncorrectInputsException
 */
public function getBeforeDate(string $figi, DateTime $dateTime): Dividends;

/**
 * @throws IncorrectInputsException
 * @throws SourceFaultException
 */
public function getByPeriod(string $figi, DateTime $fromDateTime, DateTime $toDateTime): Dividends;
```

*Figi* - instrument identifier.

*Dividends* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividends*, an immutable tuple of *Dividend* type objects.

*Dividend* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\models\Dividend*, describes the dividend data of the instrument, scheme definition here https://tinkoff.github.io/investAPI/swagger-ui/#/InstrumentsService/InstrumentsService_GetDividends

*DividendsServiceException* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\DividendsServiceException*, the base exception abstract class of this component.

*IncorrectInputsException* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\IncorrectInputsException*, the exception thrown if the input data for searching for instrument dividends was incorrect, for example searching by figi for a non-existent instrument.

*SourceFaultException* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\exceptions\SourceFaultException*, exception thrown if an error has occurred on the server side of the api tinkoff investment.

*DividendsRequestInterface* - definition - *rocketfellows\TinkoffInvestV1MethodGetDividends\DividendsRequestInterface*, the interface with which the *DividendsService* service works to receive data on instrument dividends from various sources. An interface must be implemented by an adapter, such as an adapter for rest, soap, gRpc, etc.

```php
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
```

## Adapters

TODO

## REST adapter

TODO

## Service usage examples

TODO

## Contributing

Welcome to pull requests. If there is a major changes, first please open an issue for discussion.

Please make sure to update tests as appropriate.
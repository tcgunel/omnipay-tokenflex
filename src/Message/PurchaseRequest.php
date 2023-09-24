<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Helper;
use Omnipay\Tokenflex\Constants\SalesMediaTypes;
use Omnipay\Tokenflex\Traits\HasParameters;

class PurchaseRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public string $endpoint = '/Sales';

    /**
     * @throws InvalidRequestException|InvalidCreditCardException
     */
    public function getData(): array
    {
        $this->validate(
            'username',
            'password',
            'merchant_no',
            'terminal_no',
            'transactionId',
            'cashier_info',
            'service_id',
            'amount',
            'sales_media_type',
        );

        switch ($this->getSalesMediaType()) {
            case SalesMediaTypes::CardNo:

                $salesMediaData = $this->getCard()->getNumber();

                if (!Helper::validateLuhn($salesMediaData)) {
                    throw new InvalidCreditCardException('Card number is invalid');
                }

                break;
            case SalesMediaTypes::GsmNumber:

                $this->validate(
                    'phone',
                    'phone_extension',
                );

                $salesMediaData = $this->getPhoneExtension() . '|' . $this->getPhone();

                break;
            case SalesMediaTypes::PaymentCode:

                $this->validate(
                    'payment_code',
                );

                $salesMediaData = $this->getPaymentCode();

                break;
        }

        return [
            'headers'        => [
                'Username' => $this->getUsername(),
                'Password' => $this->getPassword(),
            ],
            'request_params' => [
                'ReferenceId'       => $this->getTransactionId(),
                'CashierInfo'       => $this->getCashierInfo(),
                'MerchantNo'        => $this->getMerchantNo(),
                'TerminalNo'        => $this->getTerminalNo(),
                'ServiceId'         => $this->getServiceId(),
                'TransactionAmount' => number_format($this->getAmount(), 2, '', ''),
                'SalesMediaType'    => $this->getSalesMediaType(),
                'SalesMediaData'    => $salesMediaData,
                'UseStoredCard'     => $this->getUseStoredCard(),
            ],
        ];
    }

    public function sendData($data): PurchaseResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            array_merge($data['headers'], [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ]),
            $data['request_params']
        );

        return $this->createResponse($httpResponse);
    }

    /**
     * @throws \JsonException
     */
    protected function createResponse($data): PurchaseResponse
    {
        $this->response = new PurchaseResponse($this, $data);

        return $this->response;
    }
}

<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tokenflex\Traits\HasParameters;

class RefundRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public string $endpoint = '/Rollback';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'username',
            'password',
            'merchant_no',
            'terminal_no',
            'transactionId',
            'amount',
        );

        return [
            'headers'        => [
                'Username' => $this->getUsername(),
                'Password' => $this->getPassword(),
            ],
            'request_params' => [
                'ReferenceId'       => $this->getTransactionId(),
                'MerchantNo'        => $this->getMerchantNo(),
                'TerminalNo'        => $this->getTerminalNo(),
                'TransactionAmount' => number_format($this->getAmount(), 2, '', ''),
            ],
        ];
    }

    public function sendData($data): RefundResponse
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
    protected function createResponse($data): RefundResponse
    {
        $this->response = new RefundResponse($this, $data);

        return $this->response;
    }
}

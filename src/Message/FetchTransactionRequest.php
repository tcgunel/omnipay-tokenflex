<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tokenflex\Traits\HasParameters;

class FetchTransactionRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public string $endpoint = '/GetSaleStatus';

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
        );

        return [
            'headers'        => [
                'Username' => $this->getUsername(),
                'Password' => $this->getPassword(),
            ],
            'request_params' => [
                'ReferenceId' => $this->getTransactionId(),
                'MerchantNo'  => $this->getMerchantNo(),
                'TerminalNo'  => $this->getTerminalNo(),
            ],
        ];
    }

    public function sendData($data): FetchTransactionResponse
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            array_merge($data['headers'], [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ]),
			json_encode($data['request_params'], JSON_THROW_ON_ERROR)
        );

        return $this->createResponse($httpResponse);
    }

    /**
     * @throws \JsonException
     */
    protected function createResponse($data): FetchTransactionResponse
    {
        $this->response = new FetchTransactionResponse($this, $data);

        return $this->response;
    }
}

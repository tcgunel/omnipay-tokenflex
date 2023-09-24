<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tokenflex\Traits\HasParameters;

class ResendOtpRequest extends RemoteAbstractRequest
{
    use HasParameters;

    public string $endpoint = '/VerifyOtp';

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
                'ReferenceId'       => $this->getTransactionId(),
                'MerchantNo'        => $this->getMerchantNo(),
                'TerminalNo'        => $this->getTerminalNo(),
            ],
        ];
    }

    public function sendData($data): ResendOtpResponse
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
    protected function createResponse($data): ResendOtpResponse
    {
        $this->response = new ResendOtpResponse($this, $data);

        return $this->response;
    }
}

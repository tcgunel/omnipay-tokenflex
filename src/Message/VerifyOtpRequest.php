<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tokenflex\Traits\HasParameters;

class VerifyOtpRequest extends RemoteAbstractRequest
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
            'amount',
            'otp_code',
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
                'OtpCode'           => $this->getOtpCode(),
            ],
        ];
    }

    public function sendData($data): VerifyOtpResponse
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
    protected function createResponse($data): VerifyOtpResponse
    {
        $this->response = new VerifyOtpResponse($this, $data);

        return $this->response;
    }
}

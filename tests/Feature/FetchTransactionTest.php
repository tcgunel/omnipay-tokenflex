<?php

namespace Omnipay\Tokenflex\Tests\Feature;

use Omnipay\Tokenflex\Constants\SalesMediaTypes;
use Omnipay\Tokenflex\Exceptions\SalesMediaTypeException;
use Omnipay\Tokenflex\Exceptions\ServiceIdException;
use Omnipay\Tokenflex\Message\FetchTransactionRequest;
use Omnipay\Tokenflex\Message\FetchTransactionResponse;
use Omnipay\Tokenflex\Models\FetchTransactionDataResponseModel;
use Omnipay\Tokenflex\Models\FetchTransactionResponseModel;
use Omnipay\Tokenflex\Tests\TestCase;

class FetchTransactionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_fetch_transaction_request(): void
    {
        $params = [
            'username'      => 'User001',
            'password'      => 'P@ssw0rd',
            'merchant_no'   => 1234567,
            'terminal_no'   => 123123,
            'transactionId' => time(),
        ];

        $params_to_be_expected_back = [
            'headers'        => [
                'Username' => $params['username'],
                'Password' => $params['password'],
            ],
            'request_params' => [
                'ReferenceId' => $params['transactionId'],
                'MerchantNo'  => $params['merchant_no'],
                'TerminalNo'  => $params['terminal_no'],
            ],
        ];

        $request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_fetch_transaction_response(): void
    {
        $response_data = [
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'ReferenceId'       => 17,
                'MerchantNo'        => 88,
                'TerminalNo'        => 99,
                'Status'            => 3,
                'TransactionAmount' => 69.69,
                'StatusMessage'     => 'İşlem konfirm edildi / Başarılı.'
            ],
        ];

        $response = new FetchTransactionResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new FetchTransactionResponseModel([
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'ReferenceId'       => 17,
                'MerchantNo'        => 88,
                'TerminalNo'        => 99,
                'Status'            => 3,
                'TransactionAmount' => 69.69,
                'StatusMessage'     => 'İşlem konfirm edildi / Başarılı.'
            ],
        ]);

        $this->assertEquals($expected, $data);
    }
}

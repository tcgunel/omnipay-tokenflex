<?php

namespace Omnipay\Tokenflex\Tests\Feature;

use Omnipay\Tokenflex\Message\ResendOtpRequest;
use Omnipay\Tokenflex\Message\ResendOtpResponse;
use Omnipay\Tokenflex\Models\ResendOtpResponseModel;
use Omnipay\Tokenflex\Tests\TestCase;

class ResendOtpTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_resend_otp_request(): void
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
                'ReferenceId'       => $params['transactionId'],
                'MerchantNo'        => $params['merchant_no'],
                'TerminalNo'        => $params['terminal_no'],
            ],
        ];

        $request = new ResendOtpRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_resend_otp_response(): void
    {
        $response_data = [
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => null,
        ];

        $response = new ResendOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new ResendOtpResponseModel([
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => null
        ]);

        $this->assertEquals($expected, $data);
    }

    public function test_resend_otp_response_error(): void
    {
        $response_data = [
            'Status'      => 0,
            'Code'        => 500,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => null,
        ];

        $response = new ResendOtpResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new ResendOtpResponseModel([
            'Status'      => 0,
            'Code'        => 500,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => null
        ]);

        $this->assertEquals($expected, $data);
        $this->assertEquals(500, $response->getCode());
    }
}

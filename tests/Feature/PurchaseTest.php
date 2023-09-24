<?php

namespace Omnipay\Tokenflex\Tests\Feature;

use Omnipay\Tokenflex\Constants\SalesMediaTypes;
use Omnipay\Tokenflex\Exceptions\SalesMediaTypeException;
use Omnipay\Tokenflex\Exceptions\ServiceIdException;
use Omnipay\Tokenflex\Message\PurchaseRequest;
use Omnipay\Tokenflex\Message\PurchaseResponse;
use Omnipay\Tokenflex\Models\PurchaseDataResponseModel;
use Omnipay\Tokenflex\Models\PurchaseResponseModel;
use Omnipay\Tokenflex\Tests\TestCase;

class PurchaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_purchase_request_with_card(): void
    {
        $params = [
            'username'         => 'User001',
            'password'         => 'P@ssw0rd',
            'merchant_no'      => 1234567,
            'terminal_no'      => 123123,
            'transactionId'    => time(),
            'cashier_info'     => 'Cashier Data',
            'service_id'       => 888888,
            'amount'           => '9.99',
            'sales_media_type' => SalesMediaTypes::CardNo,
            'card'             => ['number' => '6539107881911853'],
        ];

        $params_to_be_expected_back = [
            'headers'        => [
                'Username' => $params['username'],
                'Password' => $params['password'],
            ],
            'request_params' => [
                'ReferenceId'       => $params['transactionId'],
                'CashierInfo'       => $params['cashier_info'],
                'MerchantNo'        => $params['merchant_no'],
                'TerminalNo'        => $params['terminal_no'],
                'ServiceId'         => $params['service_id'],
                'TransactionAmount' => number_format($params['amount'], 2, '', ''),
                'SalesMediaType'    => $params['sales_media_type'],
                'SalesMediaData'    => $params['card']['number'],
                'UseStoredCard'     => false,
            ],
        ];

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_purchase_request_with_payment_code(): void
    {
        $params = [
            'username'         => 'User001',
            'password'         => 'P@ssw0rd',
            'merchant_no'      => 1234567,
            'terminal_no'      => 123123,
            'transactionId'    => time(),
            'cashier_info'     => 'Cashier Data',
            'service_id'       => 888888,
            'amount'           => '9.99',
            'sales_media_type' => SalesMediaTypes::PaymentCode,
            'payment_code'     => 564788,
        ];

        $params_to_be_expected_back = [
            'headers'        => [
                'Username' => $params['username'],
                'Password' => $params['password'],
            ],
            'request_params' => [
                'ReferenceId'       => $params['transactionId'],
                'CashierInfo'       => $params['cashier_info'],
                'MerchantNo'        => $params['merchant_no'],
                'TerminalNo'        => $params['terminal_no'],
                'ServiceId'         => $params['service_id'],
                'TransactionAmount' => number_format($params['amount'], 2, '', ''),
                'SalesMediaType'    => $params['sales_media_type'],
                'SalesMediaData'    => $params['payment_code'],
                'UseStoredCard'     => false,
            ],
        ];

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_purchase_request_with_gsm_number(): void
    {
        $params = [
            'username'         => 'User001',
            'password'         => 'P@ssw0rd',
            'merchant_no'      => 1234567,
            'terminal_no'      => 123123,
            'transactionId'    => time(),
            'cashier_info'     => 'Cashier Data',
            'service_id'       => 888888,
            'amount'           => '9.99',
            'sales_media_type' => SalesMediaTypes::GsmNumber,
            'phone'            => 5554443322,
            'phone_extension'  => 90,
        ];

        $params_to_be_expected_back = [
            'headers'        => [
                'Username' => $params['username'],
                'Password' => $params['password'],
            ],
            'request_params' => [
                'ReferenceId'       => $params['transactionId'],
                'CashierInfo'       => $params['cashier_info'],
                'MerchantNo'        => $params['merchant_no'],
                'TerminalNo'        => $params['terminal_no'],
                'ServiceId'         => $params['service_id'],
                'TransactionAmount' => number_format($params['amount'], 2, '', ''),
                'SalesMediaType'    => $params['sales_media_type'],
                'SalesMediaData'    => $params['phone_extension'] . '|' . $params['phone'],
                'UseStoredCard'     => false,
            ],
        ];

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $data = $request->getData();

        self::assertEquals($data, $params_to_be_expected_back);
    }

    public function test_purchase_request_throws_sales_media_type_exception(): void
    {
        $params = [
            'username'         => 'User001',
            'password'         => 'P@ssw0rd',
            'merchant_no'      => 1234567,
            'terminal_no'      => 123123,
            'transactionId'    => time(),
            'cashier_info'     => 'Cashier Data',
            'service_id'       => 888888,
            'amount'           => '9.99',
            'sales_media_type' => 100,
            'card'             => ['number' => '6539107881911853'],
        ];

        $this->expectException(SalesMediaTypeException::class);

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $request->getData();
    }

    public function test_purchase_request_throws_service_id_exception(): void
    {
        $params = [
            'username'         => 'User001',
            'password'         => 'P@ssw0rd',
            'merchant_no'      => 1234567,
            'terminal_no'      => 123123,
            'transactionId'    => time(),
            'cashier_info'     => 'Cashier Data',
            'service_id'       => 888888,
            'amount'           => '9.99',
            'sales_media_type' => 100,
            'card'             => ['number' => '6539107881911853'],
        ];

        $this->expectException(ServiceIdException::class);

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize($params);

        $request->getData();
    }

    public function test_purchase_response(): void
    {
        $response_data = [
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'IsSuccess'               => true,
                'ErrorCode'               => null,
                'Description'             => 'sale description',
                'TransactionId'           => 23456765,
                'OnlineBalanceAfterTrx'   => 69.69,
                'TransactionApprovalCode' => 'approval code',
                'LoyaltyMessage'          => 'loyalty discount etc. info message',
                'BarcodeData'             => 'qq',
                'OtpRequired'             => true,
            ],
        ];

        $response = new PurchaseResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertTrue($response->isSuccessful());

        $expected = new PurchaseResponseModel([
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'IsSuccess'               => true,
                'ErrorCode'               => null,
                'Description'             => 'sale description',
                'TransactionId'           => 23456765,
                'OnlineBalanceAfterTrx'   => 69.69,
                'TransactionApprovalCode' => 'approval code',
                'LoyaltyMessage'          => 'loyalty discount etc. info message',
                'BarcodeData'             => 'qq',
                'OtpRequired'             => true,
            ]
        ]);

        $this->assertEquals($expected, $data);
    }

    public function test_purchase_response_error(): void
    {
        $response_data = [
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'IsSuccess'               => false,
                'ErrorCode'               => 500,
                'Description'             => 'sale description',
                'TransactionId'           => 23456765,
                'OnlineBalanceAfterTrx'   => 69.69,
                'TransactionApprovalCode' => 'approval code',
                'LoyaltyMessage'          => 'loyalty discount etc. info message',
                'BarcodeData'             => 'qq',
                'OtpRequired'             => true,
            ],
        ];

        $response = new PurchaseResponse($this->getMockRequest(), $response_data);

        $data = $response->getData();

        $this->assertFalse($response->isSuccessful());

        $expected = new PurchaseResponseModel([
            'Status'      => 1,
            'Code'        => null,
            'Message'     => 'message',
            'Description' => 'description',
            'Data'        => [
                'IsSuccess'               => false,
                'ErrorCode'               => 500,
                'Description'             => 'sale description',
                'TransactionId'           => 23456765,
                'OnlineBalanceAfterTrx'   => 69.69,
                'TransactionApprovalCode' => 'approval code',
                'LoyaltyMessage'          => 'loyalty discount etc. info message',
                'BarcodeData'             => 'qq',
                'OtpRequired'             => true,
            ]
        ]);

        $this->assertEquals($expected, $data);
        $this->assertEquals(500, $response->getCode());
    }
}

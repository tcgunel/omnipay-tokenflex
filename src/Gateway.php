<?php

namespace Omnipay\Tokenflex;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Tokenflex\Traits\HasParameters;

/**
 * Tokenflex Gateway
 * (c) Tolga Can Günel
 * 2015, mobius.studio
 * http://www.github.com/tcgunel/omnipay-tokenflex
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use HasParameters;

    public function getName(): string
    {
        return 'Tokenflex';
    }

    public function getDefaultParameters()
    {
        return [
            'username'        => null,
            'password'        => null,
            'merchant_no'     => null,
            'terminal_no'     => null,
        ];
    }

    public function purchase(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\RefundRequest', $parameters);
    }

    public function void(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\VoidRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\FetchTransactionRequest', $parameters);
    }

    public function verifyOtp(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\VerifyOtpRequest', $parameters);
    }

    public function resendOtp(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Tokenflex\Message\ResendOtpRequest', $parameters);
    }

    public function supportsVerifyOtp()
    {
        return method_exists($this, 'verifyOtp');
    }

    public function supportsResendOtp()
    {
        return method_exists($this, 'resendOtp');
    }
}

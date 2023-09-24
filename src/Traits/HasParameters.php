<?php

namespace Omnipay\Tokenflex\Traits;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tokenflex\Constants\SalesMediaTypes;
use Omnipay\Tokenflex\Constants\Services;
use Omnipay\Tokenflex\Exceptions\SalesMediaTypeException;
use Omnipay\Tokenflex\Exceptions\ServiceIdException;

trait HasParameters
{
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getEndpoint()
    {
        return
            $this->getTestMode() ?
                'https://test-onlineauthapi.tokenflex.com.tr/api/Transaction' . $this->endpo:
                '' . $this->endpoint;
    }

    public function getCashierInfo()
    {
        return $this->getParameter('cashier_info');
    }

    public function setCashierInfo($value)
    {
        return $this->setParameter('cashier_info', $value);
    }

    public function getServiceId()
    {
        return $this->getParameter('service_id');
    }

    public function setServiceId($value)
    {
        if (!in_array($value, Services::list(), true)) {

            throw new ServiceIdException(sprintf('Service Id değeri şunlardan biri olmalıdır: %s', implode(', ', Services::list())));

        }

        return $this->setParameter('service_id', $value);
    }

    public function getSalesMediaType()
    {
        return $this->getParameter('sales_media_type');
    }

    public function setSalesMediaType($value)
    {
        if (!in_array($value, SalesMediaTypes::list(), true)) {

            throw new SalesMediaTypeException(sprintf('SalesMediaType değeri şunlardan biri olmalıdır: %s', implode(', ', SalesMediaTypes::list())));

        }

        return $this->setParameter('sales_media_type', $value);
    }

    public function getMerchantNo()
    {
        return $this->getParameter('merchant_no');
    }

    public function setMerchantNo($value)
    {
        return $this->setParameter('merchant_no', $value);
    }

    public function getTerminalNo()
    {
        return $this->getParameter('terminal_no');
    }

    public function setTerminalNo($value)
    {
        return $this->setParameter('terminal_no', $value);
    }

    public function getUseStoredCard()
    {
        return $this->getParameter('use_stored_card') ?? false;
    }

    public function setUseStoredCard($value)
    {
        return $this->setParameter('use_stored_card', $value);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    public function getPhoneExtension()
    {
        return $this->getParameter('phone_extension');
    }

    public function setPhoneExtension($value)
    {
        return $this->setParameter('phone_extension', $value);
    }

    public function getPaymentCode()
    {
        return $this->getParameter('payment_code');
    }

    public function setPaymentCode($value)
    {
        return $this->setParameter('payment_code', $value);
    }

    public function getOtpCode()
    {
        return $this->getParameter('otp_code');
    }

    public function setOtpCode($value)
    {
        return $this->setParameter('otp_code', $value);
    }
}

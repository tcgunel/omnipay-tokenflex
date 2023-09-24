<?php

namespace Omnipay\Tokenflex\Constants;

class SalesMediaTypes
{
    public const CardNo = 1;

    public const QrCode = 2;

    public const PaymentCode = 3;

    public const GsmNumber = 4;

    public static function list(): array
    {
        return [
            self::CardNo,
            self::QrCode,
            self::PaymentCode,
            self::GsmNumber,
        ];
    }
}

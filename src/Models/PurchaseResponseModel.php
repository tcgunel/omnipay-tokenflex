<?php

namespace Omnipay\Tokenflex\Models;

class PurchaseResponseModel extends BaseModel
{
    /**
     * 0: Başarısız, 1: Başarılı
     */
    public int $Status;

    /**
     * Başarısız olma durumunda hata kodu
     */
    public ?int $Code;

    /**
     * Başarısız olması durumunda hata mesajı
     */
    public ?string $Message;

    /**
     * Başarısız olması durumunda hata açıklaması
     */
    public ?string $Description;

    /**
     * Başarılı olma durumunda, fonksiyona özel object.
     */
    public PurchaseDataResponseModel $Data;
}

class PurchaseDataResponseModel extends BaseModel
{
    public bool $IsSuccess;

    public ?int $ErrorCode;

    public ?string $Description;

    public ?int $TransactionId;

    public ?float $OnlineBalanceAfterTrx;

    public ?string $TransactionApprovalCode;

    public ?string $LoyaltyMessage;

    public ?string $BarcodeData;

    public bool $OtpRequired;
}

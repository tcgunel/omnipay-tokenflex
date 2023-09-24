<?php

namespace Omnipay\Tokenflex\Models;

class FetchTransactionResponseModel extends BaseModel
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
    public FetchTransactionDataResponseModel $Data;
}

class FetchTransactionDataResponseModel extends BaseModel
{
    /**
     * Satışın başarılı olması durumunda gönderilen değer.
     */
    public int $ReferenceId;

    /**
     * TokenFlex tarafında üyeye ait üye numarası.
     */
    public int $MerchantNo;

    /**
     * Üye iş yeri tarafında üyeye ait terminal numarası
     */
    public int $TerminalNo;

    /**
     * 0-InProgress :Satıl isteği alındı,
     * 1-WaitingInquiry:İşleme onay verildi, terminal sorgulaması bekleniyor,
     * 2-WaitingConfirmation:İşlem sorgulaması yapıldı, konfirmasyon bekleniyor,
     * 3- Succeeded: İşlem konfirm edildi / Başarılı,
     * 4- Rollbacked: İşlem reverse edildi,
     * 5- Rejected: İşlem reject edildi,
     * 6- Voided: İşlem iptal edildi,
     * 7- WaitingOtpValidation:Otp doğrulaması bekleniyor.
     */
    public int $Status;

    public string $StatusMessage;

    /**
     * Kuruş cinsinden işlem tutarı. Örn: 10,25 TL için “1025”, 75 kuruş için “75” olarak gönderilmektedir.
     */
    public float $TransactionAmount;
}

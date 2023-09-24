<?php

namespace Omnipay\Tokenflex\Models;

class VoidResponseModel extends BaseModel
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
    public ?array $Data;
}

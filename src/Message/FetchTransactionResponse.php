<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Tokenflex\Models\FetchTransactionResponseModel;

class FetchTransactionResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
    {
        parent::__construct($request, $data);

        $this->response = new FetchTransactionResponseModel((array)$this->response);

        if (isset($this->response->Data->Status)) {
            switch ($this->response->Data->Status) {
                case 0:
                    $this->response->Data->StatusMessage = 'Satış isteği alındı.';
                    break;
                case 1:
                    $this->response->Data->StatusMessage = 'İşleme onay verildi, terminal sorgulaması bekleniyor.';
                    break;
                case 2:
                    $this->response->Data->StatusMessage = 'İşlem sorgulaması yapıldı, konfirmasyon bekleniyor.';
                    break;
                case 3:
                    $this->response->Data->StatusMessage = 'İşlem konfirm edildi / Başarılı.';
                    break;
                case 4:
                    $this->response->Data->StatusMessage = 'İşlem reverse edildi.';
                    break;
                case 5:
                    $this->response->Data->StatusMessage = 'İşlem reject edildi.';
                    break;
                case 6:
                    $this->response->Data->StatusMessage = 'İşlem iptal edildi.';
                    break;
                case 7:
                    $this->response->Data->StatusMessage = 'Otp doğrulaması bekleniyor.';
                    break;
            }
        }
    }

    public function isSuccessful(): bool
    {
        return $this->response->Status === 1;
    }

    public function getMessage(): ?string
    {
        return $this->isSuccessful() ? $this->response->Data->StatusMessage : $this->response->Message . '' . $this->response->Description;
    }

    public function getCode()
    {
        return $this->response->Code;
    }

    public function getData(): FetchTransactionResponseModel
    {
        return $this->response;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getRedirectUrl()
    {
        return '';
    }
}

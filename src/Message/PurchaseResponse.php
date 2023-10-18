<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Tokenflex\Models\PurchaseResponseModel;

class PurchaseResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new PurchaseResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
        return $this->response->Status === 1 && $this->response->Data->IsSuccess === true;
	}

	public function getMessage(): ?string
	{
		return $this->response->Message ?? $this->response->Description ?? $this->response->Data->Description;
	}

    public function getCode()
    {
        return $this->response->Data->ErrorCode ?? $this->response->Code;
    }

    public function getData(): PurchaseResponseModel
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

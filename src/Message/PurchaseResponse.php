<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Tokenflex\Models\PurchaseResponseModel;

class PurchaseResponse extends AbstractResponse
{
	protected PurchaseResponseModel $response;

	protected $request;

    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->request = $request;

		$this->response = new PurchaseResponseModel(json_decode(json_encode($data, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR));
	}

	public function isSuccessful(): bool
	{
        return $this->response->Status === 1 && $this->response->Data->IsSuccess === true;
	}

	public function getMessage(): ?string
	{
		return $this->response->Message . '' . $this->response->Description;
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

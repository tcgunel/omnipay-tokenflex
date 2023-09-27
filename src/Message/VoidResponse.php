<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Tokenflex\Models\VoidResponseModel;

class VoidResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new VoidResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
        return $this->response->Status === 1;
	}

	public function getMessage(): ?string
	{
		return $this->response->Message . '' . $this->response->Description;
	}

    public function getCode()
    {
        return $this->response->Code;
    }

    public function getData(): VoidResponseModel
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

<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Tokenflex\Models\ResendOtpResponseModel;

class ResendOtpResponse extends RemoteAbstractResponse
{
    /**
     * @throws \JsonException
     */
    public function __construct($request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new ResendOtpResponseModel((array)$this->response);
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

    public function getData(): ResendOtpResponseModel
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

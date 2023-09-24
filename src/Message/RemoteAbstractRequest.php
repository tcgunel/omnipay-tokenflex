<?php

namespace Omnipay\Tokenflex\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Tokenflex\Traits\HasParameters;

abstract class RemoteAbstractRequest extends AbstractRequest
{
    use HasParameters;

    abstract protected function createResponse($data);
}

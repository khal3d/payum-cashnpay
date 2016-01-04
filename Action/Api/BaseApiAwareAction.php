<?php

namespace DivLooper\Payum\CashnPay\Action\Api;

use DivLooper\Payum\CashnPay\CashnPay;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\UnsupportedApiException;

abstract class BaseApiAwareAction implements ActionInterface, ApiAwareInterface
{
    /**
     * @var \DivLooper\Payum\CashnPay\CashnPay
     */
    protected $api;
    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof CashnPay) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }
}

<?php

namespace DivLooper\Payum\CashnPay;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\InvalidArgumentException;

class CashnPay
{
    protected $options = array();

    public function __construct(array $options)
    {
        $options = ArrayObject::ensureArrayObject($options);
        $options->defaults($this->options);
        $options->validateNotEmpty(array(
            'product_id',
            'secret_key',
        ));

        if (false == is_bool($options['sandbox'])) {
            throw new InvalidArgumentException('The boolean sandbox option must be set.');
        }

        $this->options = $options;
    }

    /**
     * @param ArrayObject $model
     * @return string
     */
    public function generateVoucher(ArrayObject $model)
    {
        return $this->getGenerateVoucherEndpoint().'?'.http_build_query(array(
            'productID' => $this->options['product_id'],
            'amount' => $model['amount'],
            'refNumber' => $model['refNumber'],
        ));
    }

    /**
     * @return string
     */
    protected function getGenerateVoucherEndpoint()
    {
        return $this->options['sandbox'] ?
            'http://test.cashnpay.net/remote/generateVoucher.html' :
            'http://cashnpay.net/remote/generateVoucher.html'
            ;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function validateVoucherHash($params = array())
    {
        // Default parameters
        $params = array_merge(array(
            'refNumber' => null,
            'voucherNumber' => null,
            'voucherStatus' => null,
            'amount' => null,
            'currency' => null,
            'hashCode' => null,
        ), $params);

        $hash = md5($params['refNumber'].$params['voucherNumber'].$params['voucherStatus'].$params['amount'].$params['currency'].$params['paymentDate'].$this->options['secret_key']);

        return $hash == $params['hashCode'];
    }
}

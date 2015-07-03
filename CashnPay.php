<?php

namespace DivLooper\Payum\CashnPay;

use Buzz\Client\ClientInterface;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Response;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Bridge\Buzz\ClientFactory;
use Payum\Core\Exception\Http\HttpException;

class CashnPay
{
    protected $options = array();

    public function __construct(array $options, ClientInterface $client = null)
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
        $this->client = $client ?: ClientFactory::createCurl();
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
}

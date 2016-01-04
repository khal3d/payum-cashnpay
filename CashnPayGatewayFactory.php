<?php

namespace DivLooper\Payum\CashnPay;

use DivLooper\Payum\CashnPay\Action\Api\GenerateVoucherAction;
use DivLooper\Payum\CashnPay\Action\Api\ValidateVoucherAction;
use DivLooper\Payum\CashnPay\Action\AuthorizeAction;
use DivLooper\Payum\CashnPay\Action\CaptureAction;
use DivLooper\Payum\CashnPay\Action\NotifyAction;
use DivLooper\Payum\CashnPay\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactoryInterface;
use Payum\Core\GatewayFactory as CoreGatewayFactory;

class CashnPayGatewayFactory implements GatewayFactoryInterface
{
    /**
     * @var GatewayFactoryInterface
     */
    protected $coreGatewayFactory;
    /**
     * @var array
     */
    private $defaultConfig;
    /**
     * @param array $defaultConfig
     * @param GatewayFactoryInterface $coreGatewayFactory
     */
    public function __construct(array $defaultConfig = array(), GatewayFactoryInterface $coreGatewayFactory = null)
    {
        $this->coreGatewayFactory = $coreGatewayFactory ?: new CoreGatewayFactory();
        $this->defaultConfig = $defaultConfig;
    }
    /**
     * {@inheritDoc}
     */
    public function create(array $config = array())
    {
        return $this->coreGatewayFactory->create($this->createConfig($config));
    }

    /**
     * {@inheritDoc}
     */
    public function createConfig(array $config = array())
    {
        $config = ArrayObject::ensureArrayObject($config);
        $config->defaults($this->defaultConfig);
        $config->defaults($this->coreGatewayFactory->createConfig());

        $config->defaults(array(
            'payum.factory_name' => 'cashnpay',
            'payum.factory_title' => 'CASH\'nPAY',
            'payum.action.capture' => new CaptureAction(),
            'payum.action.notify' => new NotifyAction(),
            'payum.action.status' => new StatusAction(),

            // API
            'payum.action.api.generate_voucher' => new GenerateVoucherAction(),
            'payum.action.api.validate_voucher' => new ValidateVoucherAction(),
        ));

        // If CASHnPAY is not initialized
        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'product_id' => null,
                'secret_key' => null,
                'sandbox' => true,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = array('product_id', 'secret_key');

            // CashnPay API
            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                $cashnPayConfig = array(
                    'product_id' => $config['product_id'],
                    'secret_key' => $config['secret_key'],
                    'sandbox' => $config['sandbox'],
                );

                return new CashnPay($cashnPayConfig);
            };
        }

        return (array) $config;
    }
}

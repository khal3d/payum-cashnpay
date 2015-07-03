<?php

namespace DivLooper\Payum\CashnPay;

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
        ));

        return (array) $config;
    }
}

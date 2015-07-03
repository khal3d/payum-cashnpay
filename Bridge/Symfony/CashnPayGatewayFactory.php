<?php
namespace DivLooper\Payum\CashnPay\Bridge\Symfony;

use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Gateway\AbstractGatewayFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;


class CashnPayGatewayFactory extends AbstractGatewayFactory
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'cashnpay';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);

        $builder->children()
            ->scalarNode('product_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('secret_key')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('sandbox')->defaultTrue()->end()
        ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function getPayumGatewayFactoryClass()
    {
        return 'DivLooper\Payum\CashnPay\CashnPayGatewayFactory';
    }

    /**
     * {@inheritDoc}
     */
    protected function getComposerPackage()
    {
        return 'div-looper/payum-cashnpay';
    }

}

Payum CASHnPAY
=======
Extension for Payum which add support for [CASH'nPAY](https://cashnpay.net/) payment gateway.

## Installation

    composer require div-looper/payum-cashnpay

ACMEPaymentBundle.php:

    namespace ACME\Bundle\PaymentBundle;

    use DivLooper\Payum\CashnPay\Bridge\Symfony\CashnPayGatewayFactory;
    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\HttpKernel\Bundle\Bundle;

    class ACMEPaymentBundle extends Bundle
    {
        public function build(ContainerBuilder $container)
        {
            parent::build($container);

            /** @var $extension \Payum\Bundle\PayumBundle\DependencyInjection\PayumExtension */
            $extension = $container->getExtension('payum');
            $extension->addGatewayFactory(new CashnPayGatewayFactory());
        }
    }

config.yml:

    gateways:
        ...
        fawry:
            cashnpay:
                product_id: "00000000"
                secret_key: "0x0xX0x0"
                sandbox: true
        ...
## License

Payum-CASHnPAY is released under the [MIT License](LICENSE).

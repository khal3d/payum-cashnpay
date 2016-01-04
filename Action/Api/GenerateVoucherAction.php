<?php
namespace DivLooper\Payum\CashnPay\Action\Api;

use DivLooper\Payum\CashnPay\Api\GenerateVoucher;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Reply\HttpRedirect;

class GenerateVoucherAction extends BaseApiAwareAction
{
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request GenerateVoucher */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $voucherURL = $this->api->generateVoucher($model);

        throw new HttpRedirect(
            $voucherURL
        );
    }
    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GenerateVoucher &&
            $request->getModel() instanceof ArrayObject
            ;
    }
}

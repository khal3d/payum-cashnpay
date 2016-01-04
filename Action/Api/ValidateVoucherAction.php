<?php
namespace DivLooper\Payum\CashnPay\Action\Api;

use DivLooper\Payum\CashnPay\Api\GenerateVoucher;
use DivLooper\Payum\CashnPay\Api\ValidateVoucher;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Reply\HttpResponse;

class ValidateVoucherAction extends BaseApiAwareAction
{
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request GenerateVoucher */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = $request->getModel();

        if (false == $this->api->validateVoucherHash($model['voucher'])) {
            $model['status'] = 'INVALID';
            throw new HttpResponse('The notification is invalid', 400);
        }

        $model['status'] = $model['voucher']['voucherStatus'];

        throw new HttpResponse('Handshake', 200);
    }
    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof ValidateVoucher &&
            $request->getModel() instanceof ArrayObject
            ;
    }
}

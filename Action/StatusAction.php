<?php

namespace DivLooper\Payum\CashnPay\Action;

use Aqarmap\Bundle\CreditBundle\Entity\Payment;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Capture;
use Payum\Core\Request\GetStatusInterface;

class StatusAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request GetStatusInterface */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (isset($model['status'])) {
            switch ($model['status']) {
                case 'NEW':
                    $request->markNew();
                    break;
                case 'PAID':
                    $request->markCaptured();
                    break;
                case 'CANCELLED_BY_MERCHANT':
                case 'CANCELLED_BY_ADMIN':
                    $request->markCanceled();
                    break;
                case 'EXPIRED':
                    $request->markExpired();
                    break;
                case 'INVALID':
                    $request->markFailed();
                    break;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess;
    }
}

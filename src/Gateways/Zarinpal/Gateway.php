<?php

namespace Ar4min\PayKon\Gateways\Zarinpal;

use Ar4min\PayKon\FakeRequest;
use Ar4min\PayKon\FakeVerification;
use Ar4min\PayKon\Interfaces\CheckedPaymentInterface;
use Ar4min\PayKon\Interfaces\GatewayInterface;
use Ar4min\PayKon\Interfaces\RequestedPaymentInterface;
use Ar4min\PayKon\Money;
use Ar4min\PayKon\PendingRequest;
use Illuminate\Support\Arr;

class Gateway implements GatewayInterface
{
    /** @var array */
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getConfig(string $key = null)
    {
        return $key ? Arr::get($this->config, $key) : $this->config;
    }

    public function getCurrency(): string
    {
        return Money::TOMAN;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function getAliasDataFields(): array
    {
        return [
            'merchantId' => 'MerchantID',
            'amount' => 'Amount',
            'transactionId' => 'Authority',
            'callback' => 'CallbackURL',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'description' => 'Description',
        ];
    }

    public function getMerchantIdData()
    {
        return Arr::get($this->config, 'merchant_id');
    }

    /** @inheritDoc */
    public function requestPayment(PendingRequest $pendingRequest, FakeRequest $fakeRequest = null): RequestedPaymentInterface
    {
        $factory = (new PaymentRequest($pendingRequest));

        if ($fakeRequest) {
            return $factory->fakeFrom($fakeRequest);
        }

        return $factory->request();
    }

    /** @inheritDoc */
    public function verifyPayment(PendingRequest $pendingRequest, FakeVerification $fakeVerification = null): CheckedPaymentInterface
    {
        $factory = (new PaymentVerification($pendingRequest));

        if ($fakeVerification) {
            return $factory->fakeFrom($fakeVerification);
        }

        return $factory->verify();
    }

    /** @inheritDoc */
    public function inspectCallbackRequest(PendingRequest $pendingRequest, FakeVerification $fakeVerification = null): void
    {
        $request = app(CallbackRequest::class);

        if ($fakeVerification) {
            $request->setFakeVerification($fakeVerification);
        }

        $request->validateCallback();

        $pendingRequest->transactionId($request->getTransactionId());
    }
}

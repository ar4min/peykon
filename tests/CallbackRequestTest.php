<?php

namespace Ar4min\PayKon\Tests;

use Ar4min\PayKon\CallbackRequest;
use Ar4min\PayKon\Facades\Toman;
use Ar4min\PayKon\Gateways\IDPay\Gateway as IDPayGateway;
use Ar4min\PayKon\Gateways\Zarinpal\Gateway as ZarinpalGateway;
use Ar4min\PayKon\PendingRequest;

final class CallbackRequestTest extends TestCase
{
    /** @test */
    public function resolves_zarinpal_callback()
    {
        config([
            'toman.default' => 'zarinpal',
            'toman.gateways.zarinpal' => [
                'sandbox' => true,
                'merchant_id' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
            ],
        ]);

        Toman::fakeVerification()->successful()->withTransactionId('A123');

        $pendingRequest = app(CallbackRequest::class)->data('key', 'value');

        self::assertInstanceOf(PendingRequest::class, $pendingRequest);
        self::assertInstanceOf(ZarinpalGateway::class, $pendingRequest->getGateway());
        self::assertEquals([
            'sandbox' => true,
            'merchant_id' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
        ], $pendingRequest->getGateway()->getConfig());
    }

    /** @test */
    public function resolves_idpay_callback()
    {
        config([
            'toman.default' => 'idpay',
            'toman.gateways.idpay' => [
                'sandbox' => true,
                'api_key' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
            ],
        ]);

        Toman::fakeVerification()->successful()->withOrderId('order_1')->withTransactionId('A123');

        $pendingRequest = app(CallbackRequest::class)->data('key', 'value');

        self::assertInstanceOf(PendingRequest::class, $pendingRequest);
        self::assertInstanceOf(IDPayGateway::class, $pendingRequest->getGateway());
        self::assertEquals([
            'sandbox' => true,
            'api_key' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
        ], $pendingRequest->getGateway()->getConfig());
    }
}

<?php

namespace Ar4min\PayKon\Tests\Facades;

use Ar4min\PayKon\Facades\Toman;
use Ar4min\PayKon\Gateways\IDPay\Gateway as IDPayGateway;
use Ar4min\PayKon\Gateways\Zarinpal\Gateway as ZarinpalGateway;
use Ar4min\PayKon\PendingRequest;
use Ar4min\PayKon\Tests\TestCase;

final class TomanTest extends TestCase
{
    /** @test */
    public function resolves_to_configured_zarinpal_gateway()
    {
        config([
            'toman.default' => 'zarinpal',
            'toman.gateways.zarinpal' => [
                'sandbox' => true,
                'merchant_id' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
            ],
        ]);

        $pendingRequest = Toman::getFacadeRoot()->data('key', 'value');

        self::assertInstanceOf(PendingRequest::class, $pendingRequest);
        self::assertInstanceOf(ZarinpalGateway::class, $pendingRequest->getGateway());
        self::assertEquals([
            'sandbox' => true,
            'merchant_id' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
        ], $pendingRequest->getGateway()->getConfig());
    }

    /** @test */
    public function resolves_to_configured_idpay_gateway()
    {
        config([
            'toman.default' => 'idpay',
            'toman.gateways.idpay' => [
                'sandbox' => true,
                'api_key' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
            ],
        ]);

        $pendingRequest = Toman::getFacadeRoot()->data('key', 'value');

        self::assertInstanceOf(PendingRequest::class, $pendingRequest);
        self::assertInstanceOf(IDPayGateway::class, $pendingRequest->getGateway());
        self::assertEquals([
            'sandbox' => true,
            'api_key' => 'xxxxxxxx-yyyy-zzzz-wwww-xxxxxxxxxxxx',
        ], $pendingRequest->getGateway()->getConfig());
    }
}

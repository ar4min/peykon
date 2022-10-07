<?php

namespace Ar4min\PayKon\Gateways\Zarinpal;

use Ar4min\PayKon\Concerns\CheckedPayment as BaseCheckedPayment;
use Ar4min\PayKon\Exceptions\GatewayException;

/**
 * @method string orderId()
 */
class CheckedPayment extends BaseCheckedPayment
{
    /**
     * @var string
     */
    protected $status;

    public function __construct(string $status, GatewayException $exception = null, array $messages = [], $transactionId = null, $referenceId = null)
    {
        $this->referenceId = $referenceId;
        $this->exception = $exception;
        $this->messages = $messages;
        $this->status = $status;
        $this->transactionId = $transactionId;
    }

    public function status()
    {
        return $this->status;
    }

    public function successful(): bool
    {
        return (int) $this->status === Status::OPERATION_SUCCEED;
    }

    public function alreadyVerified(): bool
    {
        return (int) $this->status === Status::ALREADY_VERIFIED;
    }

    public function failed(): bool
    {
        return (bool) $this->exception;
    }
}

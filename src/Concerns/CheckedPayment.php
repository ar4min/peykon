<?php

namespace Ar4min\PayKon\Concerns;

use Ar4min\PayKon\Interfaces\CheckedPaymentInterface;

abstract class CheckedPayment implements CheckedPaymentInterface
{
    use InteractsWithResponse;

    /**
     * @var string
     */
    protected $referenceId;
    /**
     * @var null
     */
    protected $transactionId;

    public function referenceId(): ?string
    {
        if ($this->failed()) {
            $this->throw();
        }

        return $this->referenceId;
    }

    public function transactionId(): string
    {
        return $this->transactionId;
    }

    public function __call($name, $arguments)
    {
        throw new \BadMethodCallException(sprintf(
            'This gateway does not support `%s` method.', $name
        ));
    }
}

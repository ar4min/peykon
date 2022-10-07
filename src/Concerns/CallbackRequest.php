<?php

namespace Ar4min\PayKon\Concerns;

use Ar4min\PayKon\FakeVerification;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

abstract class CallbackRequest extends BaseFormRequest
{
    protected $stopOnFirstFailure = true;

    protected $fakeVerification;

    public function setFakeVerification(FakeVerification $fakeVerification)
    {
        $this->fakeVerification = $fakeVerification;
    }

    final public function validateResolved()
    {
    }

    public function validateCallback()
    {
        parent::validateResolved();
    }
}

<?php

namespace Ar4min\PayKon\Gateways\Zarinpal;

use Ar4min\PayKon\Concerns\CallbackRequest as BaseCallbackRequest;

/**
 * Class Requester.
 */
class CallbackRequest extends BaseCallbackRequest
{
    protected function prepareForValidation()
    {
        if ($this->fakeVerification) {
            $this->merge([
                'Authority' => $this->fakeVerification->getTransactionId(),
            ]);
        }
    }

    public function rules()
    {
        return [
            'Authority' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'Authority' => 'ZarinPal transaction id (Authority)',
        ];
    }

    public function getTransactionId()
    {
        return $this->input('Authority');
    }
}

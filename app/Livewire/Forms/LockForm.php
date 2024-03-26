<?php

namespace App\Livewire\Forms;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\LockReasonEnum;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LockForm extends Form
{
    public string $reason = '';

    public string $lockDuration = '';

    /**
     * @return non-empty-list<array-key, mixed>
     */
    public function rules(): array
    {
        return [
            'reason' => [
                Rule::in(LockReasonEnum::toValues()),
                'required',
            ],
            'lockDuration' => [
                Rule::in(BanDurationEnum::toValues()),
                'required'
            ]
        ];
    }
}

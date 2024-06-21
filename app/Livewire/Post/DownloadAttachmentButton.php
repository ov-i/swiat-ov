<?php

namespace App\Livewire\Post;

use App\Enums\Interval;
use App\Models\Posts\Attachment;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class DownloadAttachmentButton extends Component
{
    use WithRateLimiting;

    #[Modelable, Locked]
    public Attachment $attachment;

    public function render()
    {
        return view('livewire.post.download-attachment-button');
    }

    public function download(): BinaryFileResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            abort(code: Response::HTTP_TOO_MANY_REQUESTS, message: $exception->getMessage());
        }

        $fileLocation = Cache::remember(
            $this->attachment->getChecksum(),
            Interval::OneHour->value,
            fn () => $this->attachment->getLocation()
        );

        return response()->download($fileLocation);
    }
}

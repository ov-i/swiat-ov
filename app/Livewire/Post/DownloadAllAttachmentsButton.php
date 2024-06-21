<?php

namespace App\Livewire\Post;

use App\Enums\Interval;
use App\Models\Posts\Attachment;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class DownloadAllAttachmentsButton extends Component
{
    use WithRateLimiting;

    #[Modelable, Locked]
    /** @var Collection<int, Attachment> */
    public Collection $attachments;

    private const ZIP_NAME = 'swiat_ov_files.zip';

    public function render()
    {
        return view('livewire.post.download-all-attachments-button');
    }

    #[Computed(persist: true, seconds: Interval::OneDay->value)]
    public function attachments(): Collection
    {
        return $this->attachments;
    }

    /**
     * Creates a zip archive, based on currently available attachments for post.
     *
     * @return false|\Symfony\Component\HttpFoundation\BinaryFileResponse returns false, if could not create a zip archive.
     * @throws TooManyRequestsException If user has tried to generate zip file more then 1 zip/min.
     */
    public function zipAll(): false|BinaryFileResponse
    {
        try {
            $this->rateLimit(1);
        } catch(TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'zip' => __("Możesz wygenerować 1zip/min"),
            ]);
        }

        $zipArchive = new ZipArchive();

        if ($zipArchive->open(self::ZIP_NAME, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            /** @var Attachment $attachment */
            foreach ($this->attachments() as $attachment) {
                $zipArchive->addFile($attachment->getLocation(), entryname: $attachment->getFileName());
            }

            $zipArchive->close();
            return response()->download(self::ZIP_NAME)->deleteFileAfterSend();
        }

        return false;
    }
}

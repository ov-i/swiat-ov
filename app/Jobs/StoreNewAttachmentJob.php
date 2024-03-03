<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StoreNewAttachmentJob implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $disk,
        private readonly string $file,
        private readonly string $dirPath,
        private readonly string $fileName
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Storage::disk($this->disk)->putFileAs($this->dirPath, $this->file, $this->fileName);
    }
}

<?php

namespace App\Jobs;

use App\Models\Image;
use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $tempPath,
        protected int $img_id)
    {}

    /**
     * Execute the job.
     * @throws ApiError
     */
    public function handle(): void
    {
        $localPath = storage_path('app/' . $this->tempPath);

        Log::info("Local Path" . $localPath . " TEST ");

        Configuration::instance('cloudinary://516356163961216:pxiK5wQZFwZn8Cvh7kvCGTabzIA@df5wyvdtk?secure=true');

        $publicId = 'images/' . Str::uuid();

        // 🔽 RAW SDK Upload Method
        $uploadedImage = (new UploadApi())->upload($localPath, [
            'folder' => 'secure_uploads',
            'public_id' => $publicId,
            'resource_type' => 'image',
            'overwrite' => false,
        ]);

        $imageUrl = $uploadedImage['secure_url'];

        // Update image
        Image::where('id', $this->img_id)->update([
            'image_url' => $imageUrl,
        ]);

        // delete temp file
        Storage::delete($this->tempPath);
    }
}

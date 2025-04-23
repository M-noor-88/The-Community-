<?php

namespace App\Repositories;

use App\Jobs\UploadImageJob;
use App\Models\Image;

class ImageRepository
{
    public function createPlaceholder(): Image
    {
        return Image::create([
            'image_url' => 'null',
        ]);
    }

    public function storeTempImageAndDispatch($file, $imageId): void
    {
        $tempPath = $file->store('temp');
        UploadImageJob::dispatch($tempPath, $imageId);
    }
}

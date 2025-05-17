<?php

namespace App\Repositories;

use App\Jobs\UploadImageJob;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageRepository
{
    public function createPlaceholder(): Image
    {
        return Image::create([
            'image_url' => 'null',
            
        ]);
    }

    public function deleteImagePlaceholder($imageId): void
    {
        $image = Image::find($imageId);
        if ($image) {
            // Delete any temporary files if they exist
            if (Storage::exists('temp/'.$image->image_url)) {
                Storage::delete('temp/'.$image->image_url);
            }
            $image->delete();
        }
    }

    public function storeTempImageAndDispatch($file, $imageId): void
    {
        $tempPath = $file->store('temp');
        UploadImageJob::dispatch($tempPath, $imageId);
    }
}

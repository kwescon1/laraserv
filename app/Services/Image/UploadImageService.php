<?php

namespace App\Services\Image;

use App\Http\Requests\ActivityRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImageService
{
    public function uploadImage(ActivityRequest $request): string|null
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $filename = $request->file('image')->store(options: 'activities');

        $img = Image::make(Storage::disk('activities')->get($filename))
            ->resize(274, 274, function ($constraint) {
                $constraint->aspectRatio();
            });

        Storage::disk('activities')->put('thumbs/'.$request->file('image')->hashName(), $img->stream());

        return $filename;
    }
}

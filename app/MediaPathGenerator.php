<?php

namespace App;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return 'product/' . $media->id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return 'product/' . $media->id . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return 'product/' . $media->id . '/responsive/';
    }
}

<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait GeneralFunctions
{
    /**
     * Calculate the next order number for a given survey_id.
     *
     * @param int $id
     * @param string $table_name
     * @param string $column
     * @return int
     */
    public function arrangeOrderNumber($table_name, $column, $id)
    {
        // Find the max order_num for the given survey_id
        $maxOrderNum = DB::table($table_name)->where($column, $id)->max('order_num');
        // Calculate the new order_num
        $newOrderNum = $maxOrderNum !== null ? $maxOrderNum + 1 : 0;
        return $newOrderNum;
    }

    public function uploadImage($image, $imageName, $path)
    {
        //check if folder not exist and create new one
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        // Resize and compress the image using Intervention Image
        $imageResized = Image::make($image->getRealPath());
        $imageResized->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        // Save the image to the public storage
        Storage::disk('public')->put($path . $imageName, (string) $imageResized->encode());
        $imagePath = $path . $imageName;
        return $imagePath;
    }
}

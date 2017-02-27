<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * User: Laptop
 * Date: 2/3/2017
 * Time: 8:42 AM
 */
class MyHelper
{
   public static function uploadFile(UploadedFile $file, $options = array())
   {
        if (isset($options['fileable_type']) && isset($options['fileable_id'])) {
            $mimeType = $file->getClientMimeType();
            $fileableType = $options['fileable_type'];
            $fileName = $fileableType . '_' . uniqid() . '.' . $file->extension();
            $path = "";

            if (strpos($mimeType, 'image') !== false) {
                $path .= '/images';
            } else {
                $path .= '/docs';
            }

            //more type of file here !!!
            // 'videos', 'audios'

            $path .= '/' . $fileableType;
            if (isset($options['avatar']) && $options['avatar'] == 1) {
                $path .= '/avatar';
            }
            $path .= "/";

            //storage uploaded file
            $stored = Storage::disk('upload')->put($path . $fileName,  \File::get($file));

            if ($stored == 1) {
                $file = [
                    'name' => $fileName,
                    'path' => $path,
                    'fileable_id' => $options['fileable_id'],
                    'fileable_type' => $options['fileable_type'],
                ];
                return $file;
            }
            abort(502);
        }
   }
}

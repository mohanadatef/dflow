<?php

namespace Modules\Basic\Traits;

use Illuminate\Support\Facades\Storage;

trait S3Trait
{
    public function getFiles($request){
        $files = [];
        if(is_array($request->url))
        {
            foreach($request->url as $url)
            {
                $directory = '/' . $url . '/' . $request->date;
                $file = Storage::disk('s3')->allFiles($directory);
                if(count($file))
                {
                    $files[$url] = $file;
                }
            }
        }else
        {
            $directory = '/' . $request->url . '/' . $request->date;
            $files = Storage::disk('s3')->allFiles($directory);
        }
        return $files;
    }
}

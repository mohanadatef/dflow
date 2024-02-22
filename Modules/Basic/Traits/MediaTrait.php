<?php

namespace Modules\Basic\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait MediaTrait
{
    public function media_move($file, $file_name, $imageName, $path)
    {
        if (!\File::isDirectory(public_path($path . '/' . $file_name))) {
            \File::makeDirectory(public_path($path . '/' . $file_name), 0777, true, true);
        }
        $file->move(public_path($path . '/' . $file_name), $imageName);
    }

    //media_move_by_name
    public function media_move_by_name($file, $file_name, $imageName, $path)
    {
        if (!\File::isDirectory(public_path($path . '/' . $file_name))) {
            \File::makeDirectory(public_path($path . '/' . $file_name), 0777, true, true);
        }
        $session_id = user()->id;
        $from = public_path('images') ."/".$session_id."/".$file;
        $to = public_path($path . '/' . $file_name)."/".$file;
        try {
            File::move($from, $to);
        }catch (\Exception $e){}
    }

    public function media_upload($data, $request, $fileNameServer, $path, $type): void
    {
        if (isset($request->$type) && !empty($request->$type)) {
            if (is_array($request->$type)) {
                foreach ($request->$type as $media) {
                    $this->upload($media, $data, $fileNameServer, $path, $type);
                }
            } else {
                $this->upload($request->$type, $data, $fileNameServer, $path, $type);
            }
        }
    }

    public function media_save_s3($file_name, $data, $type): void
    {
        if(is_array($file_name)){
            foreach($file_name as $file){
                $data->media()->create(['file' => $file, 'type' => $type]);
            }
        }else{
            $data->media()->create(['file' => $file_name, 'type' => $type]);
        }
    }
    public function media_upload_by_name($data, $request, $fileNameServer, $path, $type): void
    {

        if (isset($request->images) && !empty($request->images)) {
            if (is_array($request->images)) {
                foreach ($request->images as $media) {
                    $this->upload_by_name(
                        $media, $data, $fileNameServer, $path, $type
                    );
                }
            } else {
                $this->upload_by_name($request->images, $data, $fileNameServer, $path, $type);
            }
        }
    }

    public function upload_by_name($file_name, $data, $fileNameServer, $path, $type): void
    {
        $fileName = $file_name;
        $file = $data->media()->create(['file' => $fileName, 'type' => $type]);
        !$file->file ?: $this->media_move_by_name($file_name, $fileNameServer, $fileName, $path);
    }


    public function upload($media, $data, $fileNameServer, $path, $type): void
    {
        $fileName = time() . $media->getClientOriginalname();
        $file = $data->media()->create(['file' => $fileName, 'type' => $type]);
        !$file->file ?: $this->media_move($media, $fileNameServer, $fileName, $path);
    }

    public function checkMediaDelete($data, $request, $type)
    {
        if (isset($request->$type) && !empty($request->$type)) {
            if ($data->$type) {
                $data->$type->delete();
            }
        }
    }

    public function deleteMedia($data)
    {
        return $data->media()?->delete();
    }

    public function dropzoneStore(Request $request)
    {
        try
        {
            $session_id = user()->id;
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images') . "/" . $session_id, $imageName);
            return response()->json(['success' => $imageName]);
        }catch(\Exception $exception)
        {
            return response()->json(['success' => $exception->getMessage()]);
        }
    }

    // Read files
    public function readFiles(Request $request)
    {
        $module = explode('/', $request->module)[0];
        $directory = asset("/images/" . $module .'/' . $request->id);
        $files_info = [];
        $path = public_path("images/" .$module .'/' . $request->id);
        // Read files
        try
        {
            foreach(\File::allFiles($path) as $file)
            {
                // Check file extension
                $filename = $file->getFilename();
                $size = $file->getSize(); // Bytes
                $files_info[] = array("name" => $filename, "size" => $size, "path" => url($directory . '\\' . $filename));
            }
        }catch(\Exception $exception)
        {
            return response()->json([]);
        }
        return response()->json($files_info);
    }
}

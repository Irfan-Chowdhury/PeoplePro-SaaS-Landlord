<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;
use Str;
use Image;
class UtilityService
{
    public function timeZoneData() : array
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone)
        {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }

    public function dateFormat() : array
    {
        return [
            'd-m-Y' => 'dd-mm-yyyy(23-05-2020)',
            'Y-m-d' => 'yyyy-mm-dd(2020-05-23)',
            'm/d/Y' => 'mm/dd/yyyy(05/23/2020)',
            'Y/m/d' => 'yyyy/mm/dd(2020/05/23)',
            'Y-M-d' => 'yyyy-MM-dd(2020-May-23)',
            'M-d-Y' => 'MM-dd-yyyy(May-23-2020)',
            'd-M-Y' => 'dd-MM-yyyy(23-May-2020)',
        ];
    }

    public function setEnv($key, $value) : void
    {
        $path = app()->environmentFilePath();
        $searchArray = array($key.'='.env($key));
        $replaceArray= array($key.'='.$value);

        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));
    }


    public function imageFileHandle($imageFile, $expectedDirectory, $isPrevImgFileDelete=true, $prevImageName=null)
    {
        $imageName = null;

        if ($imageFile) {
            $image = $imageFile;
            $imagesDirectory = public_path($expectedDirectory);

            if ($isPrevImgFileDelete && File::isDirectory($imagesDirectory)) {
                File::cleanDirectory($imagesDirectory);
            }

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis") . 1;
            $imageName = $imageName . '.' . $ext;

            $image->move($imagesDirectory, $imageName);
        }
        return $imageName;
    }

    // public function imageFileStore(object|null $image, string $directory, int $width, int $height) : string|null
    public function imageFileStore($image, $directory, $width, $height) : string|null
    {
        if (isset($image)) {
            $imageName = Str::random(10). '.' .$image->getClientOriginalExtension();
            $location  = public_path($directory.$imageName);
            Image::make($image)->resize($width, $height)->save($location);

            return $imageName;
        }

        return null;
    }

    public function directoryCleanAndImageStore($image, $directory, $width, $height) : string|null
    {
        $imageName = null;
        if ($image) {

            if (File::isDirectory($directory)) {
                File::cleanDirectory($directory);
            }

            $imageName = Str::random(10). '.' .$image->getClientOriginalExtension();
            $location  = public_path($directory.$imageName);
            Image::make($image)->resize($width, $height)->save($location);
        }

        return $imageName;
    }

    public function fileUploadHandle(object|null $file, string $directory, string $name): string | null
    {
		if (isset($file)) {
			if ($file->isValid()) {
				$fullFileName = preg_replace('/\s+/', '', $name) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($directory), $fullFileName);

				return $fullFileName;
			}
		}
        return null;
    }

    public function fileDelete(string $filePath, string|null $fileName) : void
    {
        if ($fileName && !config('database.connections.peopleprosaas_landlord') && File::exists(public_path().$filePath.$fileName))
           File::delete(public_path().$filePath.$fileName);
        else if($fileName && File::exists($filePath.$fileName))
           File::delete($filePath.$fileName);

        // if($fileName && !config('database.connections.peopleprosaas_landlord') && file_exists('public/'.$filePath.$fileName))
        //     unlink('public/'.$filePath.$fileName);
        // elseif($fileName && file_exists($filePath.$fileName))
        //     unlink($filePath.$fileName);
    }

    public function slugGenerate($string) : string
    {
        $string = strtolower($string);

        return preg_replace('/\s+/u', '-', trim($string));
    }
}

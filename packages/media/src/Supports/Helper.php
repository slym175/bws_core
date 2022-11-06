<?php

namespace Bws\Media\Supports;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Helper
{
    public static function autoload(string $directory)
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

    public function formatTime(Carbon $timestamp, $format = 'j M Y H:i')
    {
        $first = Carbon::create(0000, 0, 0, 00, 00, 00);

        if ($timestamp->lte($first)) {
            return '';
        }

        return $timestamp->format($format);
    }

    public function formatDate($date, $format = null)
    {
        if (empty($format)) {
            $format = 'd-m-Y';
        }

        if (empty($date)) {
            return $date;
        }

        return self::formatTime(Carbon::parse($date), $format);
    }

    public function getFileData($file, $convertToArray = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convertToArray) {
                return json_decode($file, true);
            }

            return $file;
        }

        if (!$convertToArray) {
            return null;
        }

        return [];
    }

    public function saveFileData($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = $this->jsonEncodePrettify($data);
            }

            if (!File::isDirectory(File::dirname($path))) {
                File::makeDirectory(File::dirname($path), 493, true);
            }

            File::put($path, $data);

            return true;
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
            return false;
        }
    }

    public function jsonEncodePrettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

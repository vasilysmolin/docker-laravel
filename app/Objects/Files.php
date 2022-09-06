<?php

namespace App\Objects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Files
{

    protected static $CROP = [
        [
            'width' => 180,
            'height' => 180,
        ],
        [
            'width' => 360,
            'height' => 360,
        ],
        [
            'width' => 400,
            'height' => 400,
        ],
        [
            'width' => 800,
            'height' => 800,
        ],
    ];

    /**
     * @param $modelPhoto
     * @return string|null
     */
    public function getFilePath($modelPhoto): ?string
    {
        if(isset($modelPhoto->name)) {
            $path = $this->getOptimizeDirectoryS3($modelPhoto->name);
            $url = Storage::disk('s3')->url($path . '_'
                . 400 . 'x'
                . 400 . '.' .
                'jpg');
        }

        return $url ?? null;
    }

    /**
     * @param $model
     * @param array|null $files
     * @throws \Exception
     */
    public function save($model, ?array $files): void
    {

        if (isset($files) && count($files) > 0) {
            foreach ($files as $file) {
                $dataFile = $this->preparationFileS3($file);
                $model->image()->create([
                    'mimeType' => $dataFile['mineType'],
                    'extension' => $dataFile['extension'],
                    'name' => $dataFile['name'],
                    'uniqueValue' => $dataFile['name'],
                    'size' => $dataFile['size'],
                ]);
            }
        }
    }

    public function saveByUrl($model, $url): void
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $contents = @file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($contents !== false) {
            $name = Str::random(40);
            $mineType = 'image/jpeg';
            $extension = 'jpg';
            $size = 999;
            $path = $this->getOptimizeDirectoryS3($name);

            foreach (self::$CROP as $resolution) {
                $image = \Intervention\Image\Facades\Image::make($contents);
                $filteredImage = $image
                    ->fit($resolution['width'], $resolution['height'])
                    ->encode('jpg', 100);
                Storage::disk('s3')->put(
                    $path . '_'
                    . $resolution['width'] . 'x'
                    . $resolution['height'] . '.' .
                    'jpg',
                    $filteredImage
                );
            }
            $model->image()->create([
                'mimeType' => $mineType,
                'extension' => $extension,
                'name' => $name,
                'size' => $size,
            ]);
        }
    }

    /**
     * @param UploadedFile $file
     * @return array
     * @throws \Exception
     */
    private function preparationFileS3(
        UploadedFile $file
    ): array {
        $extension = $this->getFileType($file->getClientOriginalName());
        $name = $this->generateFileName();
        $mineType = $file->getClientMimeType();
        $sizeFile = $file->getSize();
        $path = $this->getOptimizeDirectoryS3($name);


        foreach (self::$CROP as $resolution) {
            $image = \Intervention\Image\Facades\Image::make($file);
            $filteredImage = $image
                ->fit($resolution['width'], $resolution['height'])
                ->encode('jpg', 100);
            Storage::disk('s3')->put(
                $path . '_'
                . $resolution['width'] . 'x'
                . $resolution['height'] . '.' .
                'jpg',
                $filteredImage
            );
        }

        return [
            'mineType' => $mineType,
            'extension' => $extension,
            'size' => $sizeFile,
            'name' => $name,
            'path' => $path,
        ];
    }

    private function getFileType(string $nameWithType): string
    {
        $explodeAvatar = explode('.', $nameWithType);

        if (!is_array($explodeAvatar) && count($explodeAvatar) < 1) {
            throw new ModelNotFoundException(__('errors.not_found'), 404);
        }
        return $explodeAvatar[1];
    }

    /**
     * @param string|null $fileName
     * @return string
     * @throws \Exception
     */
    private function generateFileName(?string $fileName = null): string
    {
        return md5(microtime() . random_int(0, 9999));
    }

    protected function getOptimizeDirectoryS3($string): string
    {
        $dir = '';
        if (mb_strlen($string, 'utf-8') > 4) {
            $dir = mb_substr($string, 0, 2, 'utf-8') . '/' .  mb_substr($string, 2, 2, 'utf-8') . '/';
        }

        return $dir . $string . '/' . $string;
    }

}

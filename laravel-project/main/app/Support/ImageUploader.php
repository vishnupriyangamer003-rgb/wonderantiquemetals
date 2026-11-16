<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

/**
 * Safe image storage: real MIME check, re-encode through GD (drops EXIF and any
 * embedded payload), random file name, stored under the public assets/uploads folder.
 */
class ImageUploader
{
    public const DIR = 'assets/uploads';
    public const MAX_KB = 2048;
    public const MAX_PIXELS = 6000;
    public const MIMES = ['jpg', 'jpeg', 'png', 'webp'];

    /** Validation rules reused by every controller. */
    public static function rules(bool $required = false): array
    {
        return [
            $required ? 'required' : 'nullable',
            'file',
            'image',
            'mimes:'.implode(',', self::MIMES),
            'max:'.self::MAX_KB,
            'dimensions:max_width='.self::MAX_PIXELS.',max_height='.self::MAX_PIXELS,
        ];
    }

    /** @return string path relative to the public root, e.g. assets/uploads/ab12.jpg */
    public static function store(UploadedFile $file, string $field = 'image'): string
    {
        $path = $file->getRealPath();
        $info = @getimagesize($path);
        $mime = $info['mime'] ?? '';
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (! isset($allowed[$mime])) {
            throw ValidationException::withMessages([$field => 'Only JPG, PNG or WEBP images are allowed.']);
        }

        $src = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
        };
        if (! $src) {
            throw ValidationException::withMessages([$field => 'That image could not be read. Please upload a valid file.']);
        }

        $dir = public_path(self::DIR);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = bin2hex(random_bytes(12)).'.'.$allowed[$mime];
        $target = $dir.DIRECTORY_SEPARATOR.$name;

        if ($mime !== 'image/jpeg') {
            imagealphablending($src, false);
            imagesavealpha($src, true);
        }
        $ok = match ($mime) {
            'image/jpeg' => imagejpeg($src, $target, 85),
            'image/png' => imagepng($src, $target, 6),
            'image/webp' => imagewebp($src, $target, 85),
        };
        imagedestroy($src);

        if (! $ok) {
            throw ValidationException::withMessages([$field => 'The image could not be saved.']);
        }

        return self::DIR.'/'.$name;
    }

    /** Deletes a previously uploaded file; never touches the bundled site images. */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, self::DIR.'/') && ! str_contains($path, '..')) {
            $full = public_path($path);
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Valikgorobets\NovaMediaHub\Models\Media;

class ConvertImagesToWebP extends Command
{
    protected $signature = 'convert:images-to-webp';

    protected $description = 'Convert all images to WebP format';

    public function handle()
    {

    //    $images = File::allFiles(public_path('images'));

        $media = DB::table('media_hub')->where('id', '79')->get();
        $conversions = json_decode($media[0]->conversions, true);


        $path = parse_url(url('/') . Storage::url('media/79/conversions/' . $conversions['referens_gall']), PHP_URL_PATH);


        $path = str_replace('/storage', '', $path);


        $full_path = storage_path('app/public') . $path;
        $image = Image::make($full_path);
        $image->encode('webp')->save($full_path.'.webp');
        var_dump(url('/') . Storage::url('media/79/conversions/' . $conversions['referens_gall']));
        die();

        $url_conversion = $media->getUrl(isset($media->conversions[$conversion]) ? $conversion : '', $file_name);
        $images = [
            'url' => $url,
            'sizes' => [$conversion => $url_conversion]
        ];


        foreach ($images as $image) {
            $path = $image->getRealPath();


            if (!starts_with(mime_content_type($path), 'image/')) {
                continue;
            }

         
            $image = Image::make($path);
            $image->encode('webp')->save(str_replace('.jpg', '.webp', $path));
        }

        $this->info('All images have been converted to WebP');
    }
}

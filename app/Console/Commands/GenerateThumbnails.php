<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use App\Models\ItemImages;

class GenerateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-thumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = env('ASSETSPATHURL') . 'admin-assets/images/item/';

        $images = ItemImages::whereNull('thumbnail')->get();

        foreach ($images as $img) {

            if (!file_exists($path . $img->image)) {
                continue;
            }

            $thumbnailName = 'thumb-' . $img->image;

            $thumbnail = Image::make($path . $img->image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(null, 75);

            $thumbnail->save($path . $thumbnailName);

            $img->thumbnail = $thumbnailName;
            $img->save();
        }

        $this->info('Thumbnails generated successfully.');
    }
}

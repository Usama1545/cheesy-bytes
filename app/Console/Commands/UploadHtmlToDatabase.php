<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UploadHtmlToDatabase extends Command
{
    protected $signature = 'upload:html-to-db';
    protected $description = 'Uploads content from HTML files to the county_seo table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $directoryPath = storage_path('app/htmlfiles');

        if (!is_dir($directoryPath)) {
            $this->error("Directory does not exist: $directoryPath");
            return Command::FAILURE;
        }

        $files = glob($directoryPath . '/*.html');

        foreach ($files as $file) {
            $filename = basename($file, '.html');
            [$category, $state] = explode('-', $filename);

            $content = file_get_contents($file);

            if ($content === false) {
                $this->error("Failed to read file: $file");
                continue;
            }

            DB::table('county_seo')->insert([
                'category' => Str::slug($category, '-'),
                'county' => $state,
                'content' => $content,
            ]);

            $this->info("Uploaded: $file");
        }

        return CommandAlias::SUCCESS;
    }
}

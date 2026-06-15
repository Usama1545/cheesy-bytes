<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CountySeo;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateSeo extends Command
{
    protected $signature = 'updated:country-seo';
    protected $description = 'Uploads content from HTML files to the county_seo table';

    public function handle()
    {
        $branches = [
            'austin-pflugerville' => 3,
            'houston-richmond' => 1,
            'houston-missionbend' => 2,
            'Rosenberg' => 4,
        ];

        $seos = CountySeo::all();

        foreach ($seos as $seo) {

            $category = Category::where('slug', $seo->category)->first();

            $seo->update([
                'branch_id' => $branches[$seo->county] ?? null,
                'category_id' => $category?->id,
            ]);
        }

        $this->info('SEO records updated successfully.');

        return CommandAlias::SUCCESS;
    }
}
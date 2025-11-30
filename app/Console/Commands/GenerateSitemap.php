<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Branch;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add static URLs
        $staticUrls = [
            '/',
            '/login',
            '/register',
            '/profile',
            '/location/store',
            '/location/getDelivery/3',
        ];

        foreach ($staticUrls as $url) {
            $sitemap->add(Url::create($url));
        }

        // Fetch all branches from the database
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $sitemap->add(Url::create("/{$branch->slug}")) // Home page of the branch
            ->add(Url::create("/{$branch->slug}/categories"))
                ->add(Url::create("/{$branch->slug}/cart"))
                ->add(Url::create("/{$branch->slug}/deals"))
                ->add(Url::create("/{$branch->slug}/search"));

            // Fetch categories dynamically from the database
            $categories = Category::all();

            foreach ($categories as $category) {
                $sitemap->add(Url::create("/{$branch->slug}/menu/{$category->slug}"));
            }
        }

        // Save the sitemap to public folder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Design;
use Illuminate\Database\Seeder;

class TopOffersSeeder extends Seeder
{
    /**
     * Seed the top offers designs for the home page.
     */
    public function run(): void
    {
        $topOffers = [
            [
                'title' => 'top_offer_1',
                'page_name' => 'home',
                'description' => 'Top Offer 1',
                'image' => 'designs/top_offer_1.jpg', // You'll need to add actual images
            ],
            [
                'title' => 'top_offer_2',
                'page_name' => 'home',
                'description' => 'Top Offer 2',
                'image' => 'designs/top_offer_2.jpg',
            ],
            [
                'title' => 'top_offer_3',
                'page_name' => 'home',
                'description' => 'Top Offer 3',
                'image' => 'designs/top_offer_3.jpg',
            ],
            [
                'title' => 'top_offer_4',
                'page_name' => 'home',
                'description' => 'Top Offer 4 - Large',
                'image' => 'designs/top_offer_4.jpg',
            ],
            [
                'title' => 'top_offer_5',
                'page_name' => 'home',
                'description' => 'Top Offer 5 - Large',
                'image' => 'designs/top_offer_5.jpg',
            ],
            [
                'title' => 'new_products_banner',
                'page_name' => 'home',
                'description' => 'New Products Section Banner',
                'image' => 'designs/new_products_banner.jpg',
            ],
        ];

        foreach ($topOffers as $offer) {
            Design::updateOrCreate(
                [
                    'title' => $offer['title'],
                    'page_name' => $offer['page_name']
                ],
                $offer
            );
        }

        $this->command->info('Top Offers and New Products Banner seeded successfully!');
    }
}

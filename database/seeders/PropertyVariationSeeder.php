<?php

namespace Database\Seeders;

use App\Models\PropertyVariation;
use Illuminate\Database\Seeder;
use Modules\Cms\Models\Post;

class PropertyVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder creates sample property variations based on the Addis City Kabusa example.
     * You can run this seeder after creating a property post in the CMS.
     */
    public function run(): void
    {
        // Find a property post to attach variations to
        // You can change this query to target a specific property
        $property = Post::where('post_type_id', 4)
            ->where('slug', 'like', '%addis%')
            ->orWhere('title', 'like', '%Addis%')
            ->first();

        if (!$property) {
            $this->command->warn('No property found. Please create a property first or update the query.');
            return;
        }

        $this->command->info("Adding variations to property: {$property->title}");

        $variations = [
            [
                'name' => '150sqm – 3 Bedroom Terrace Duplex',
                'size' => '150sqm',
                'property_type' => '3 Bedroom Terrace Duplex',
                'bedrooms' => 3,
                'description' => 'Invest smart, live beautifully! Our 3-bedroom terrace duplex on 150sqm offers affordable luxury in a fast-developing estate. Perfect for young families or first-time investors, where value appreciation meets modern design.',
                'price' => 5800000,
                'payment_plan' => [
                    'initial_deposit_percentage' => 60,
                    'duration_months' => 6,
                    'description' => '60% initial deposit, spread the 40% balance in 6 months.',
                ],
                'order' => 1,
            ],
            [
                'name' => '250sqm – 3 Bedroom Semi-Detached Duplex',
                'size' => '250sqm',
                'property_type' => '3 Bedroom Semi-Detached Duplex',
                'bedrooms' => 3,
                'description' => 'Looking for space and style? Own a 3-bedroom semi-detached duplex on 250sqm of serviced land. Designed for privacy, comfort, and long-term value, this is the perfect investment for those ready to move up in life.',
                'price' => 9700000,
                'payment_plan' => [
                    'initial_deposit_percentage' => 60,
                    'duration_months' => 6,
                    'description' => '60% initial deposit, spread the 40% balance in 6 months.',
                ],
                'order' => 2,
            ],
            [
                'name' => '350sqm – 4 Bedroom Fully Detached Duplex',
                'size' => '350sqm',
                'property_type' => '4 Bedroom Fully Detached Duplex',
                'bedrooms' => 4,
                'description' => 'Your dream home begins here! This 4-bedroom fully detached duplex on 350sqm delivers space, prestige, and remarkable returns. Build your home in a secure, fast-growing community and enjoy living where elegance meets opportunity.',
                'price' => 13650000,
                'payment_plan' => [
                    'initial_deposit_percentage' => 60,
                    'duration_months' => 6,
                    'description' => '60% initial deposit, spread the 40% balance in 6 months.',
                ],
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'name' => '500sqm – 5 Bedroom Fully Detached Duplex',
                'size' => '500sqm',
                'property_type' => '5 Bedroom Fully Detached Duplex',
                'bedrooms' => 5,
                'description' => 'Go big, go exclusive. The 5-bedroom fully detached duplex on 500sqm gives you the freedom to create your luxury sanctuary. Perfect for high-end living and long-term investment because prime spaces like this don\'t stay long!',
                'price' => 19500000,
                'payment_plan' => [
                    'initial_deposit_percentage' => 60,
                    'duration_months' => 6,
                    'description' => '60% initial deposit, spread the 40% balance in 6 months.',
                ],
                'order' => 4,
            ],
        ];

        foreach ($variations as $variationData) {
            PropertyVariation::create([
                'post_id' => $property->id,
                ...$variationData,
            ]);
        }

        $this->command->info('Property variations created successfully!');
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\Area;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Government;
use App\Models\LoyaltyPoint;
use App\Models\NotificationLog;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PointTransaction;
use App\Models\Product;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        exec('php artisan passport:install');

        User::factory(3)->sequence(
            [
                'email' => 'admintest@gmail.com',
                'type' => 'admin',
                'password' => Hash::make('admin123'),
            ],
            [
                'email' => 'ahmed2@gmail.com',
                'type' => 'cashier',
                'password' => Hash::make('admin123'),
            ],
            [
                'email' => 'md.sallam@gmail.com',
                'password' => Hash::make('123456789'),
            ]
        )->create()->each(function (User $user) {
            $user->token = $user->createToken('appName')->accessToken;
            $user->save();
        });
        /** @var User $customer */
        $customer = User::find(3);

        // create other 30 users
        User::factory(30)->create();

        // create banner images
        Banner::factory(15)->create();

        // create governments && cities && areas
        Government::factory(15)->create()->each(function (Government $government) {
            City::factory(10)->create([
                'government_id' => $government->id,
            ])->each(function (City $city) {
                Area::factory(random_int(3, 15))->create([
                    'city_id' => $city->id,
                ]);
            });
        });

        // create addresses for only customer
        $customer->addresses()->createMany(
            Address::factory(random_int(1, 5))->raw([
                'area_id' => Area::inRandomOrder()->first()->id,
            ])
        );

        // categories && products
        Category::factory(10)->create([
            'category_id' => null,
        ])->each(function (Category $category) {
            // create sub categories
            Category::factory(random_int(5, 10))->create([
                'category_id' => $category->id,
            ])->each(function (Category $sub_category) {
                $sub_category->products()->createMany(
                    Product::factory(random_int(30, 70))->raw([
                        'category_id' => $sub_category->id,
                    ])
                );
            });
        });

        // create offers
        Offer::factory(7)->create()->each(function (Offer $offer) {
            foreach (range(5, 15) as $i) {
                $pId = Product::inRandomOrder()->first()->id;
                if (!OfferProduct::where('offer_id', $offer->id)->where('product_id', $pId)->exists()) {
                    $offer->products()->attach($pId);
                }
            }
        });

        // create orders
        Order::factory(5)->create([
            'user_id' => $customer->id,
            'address_id' => Address::where('user_id', $customer->id)->inRandomOrder()->first()->id,
        ])->each(function(Order $order) {
            foreach (range(1, 5) as $i) {
                new OrderProduct([
                    'product_id' => Product::inRandomOrder()->first()->id,
                    'order_id' => $order->id,
                    'quantity' => random_int(1, 7),
                    'price' => Product::inRandomOrder()->first()->price,
                ]);
            }
        });


        // favourites
        foreach (range(2, 25) as $i) {
            $customer->favourites()->attach(Product::inRandomOrder()->first());
        }

        // notification logs
        NotificationLog::factory(15)->create();

        // loyality
        LoyaltyPoint::factory(3)->create();

        // points transaction
        PointTransaction::factory(15)->create([
            'user_id' => $customer->id
        ]);
    }
}

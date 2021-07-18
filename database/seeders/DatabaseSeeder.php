<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Checklist;
use App\Models\Delivery;
use App\Models\DeliveryAddress;
use App\Models\Product;
use App\Models\ProductArticle;
use App\Models\Storage;
use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserProfile::factory(25)->create();
        for($i=1; $i<26;$i++){
            Purchase::factory()->create(['user_profile_id'=>$i,'checklist_top_id' =>$i]);
            for ($j=1; $j<4;$j++) {
                Checklist::factory()->create(['top_id'=> $i, 'bot_id'=>$j]);
            }
        }
        //Category::factory(5)->create();
        //Product::factory(20)->create();
        Storage::factory(5)->create();
        DeliveryAddress::factory(10)->create();
        Delivery::factory(10)->create();

        //ProductArticle::factory(5)->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Admin;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Lead;
use App\Models\Moderator;
use App\Models\Org;
use App\Models\Phone;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create organizations
        for ($i = 1; $i <= 16; $i++) {
            Org::create([
                "name" => "org-$i",
                "slug" => Str::slug(uniqid() . "org$i"),
            ]);
        }
        // create admin and moderators
        for ($i = 1; $i <= 5; $i++) {
            Admin::create([
                "name" => "admin$i",
                "email" => "admin$i@gmail.com",
                "image" => "admin_pic.png",
                "password" => Hash::make("admin1234"),
            ]);
            Moderator::create([
                "name" => "mod$i",
                "email" => "mod$i@gmail.com",
                "image" => "moderator_$i.jpg",
                "password" => Hash::make("moderator1234"),
            ]);
            Contact::create([
                "name" => "contact$i",
                "slug" => Str::slug(uniqid() . "contact$i"),
                "image" => "contact_$i.jpg",
                "org_id" => rand(1, 16),
            ]);
            // creating phone number and email of contact
            for ($a = 1; $a <= 2; $a++) {
                Phone::create([
                    "number" => "09" . random_int(100000000, 999999999),
                    "contact_id" => $i,
                ]);
                Email::create([
                    "name" => "contact$i" . "the" .  "$a@gmail.com",
                    "contact_id" => $i,
                ]);
            }
        }
        // create sources
        $sources = ['Phone', 'Gmail', 'Meeting', 'Conference', 'Video Conference', 'Social Media', 'Others', 'Face to Face', 'Friend', 'Travel', 'Annonymous', 'Luck'];
        foreach ($sources as $source) {
            Source::create([
                "name" => $source,
                "slug" => Str::slug(uniqid() . $source),
            ]);
        }
        // create business
        $businesses = ['Logistics', 'Telecom', 'E-commerce', 'Car Services', 'Tech Store', 'Pharmancy', 'Convenience Store', 'Supermarket', 'Delivery Service', 'Government Organization', 'Sports Accessories Store', 'Lanudry'];
        foreach ($businesses as $b) {
            Business::create([
                "name" => $b,
                "slug" => Str::slug(uniqid() . $b),
            ]);
        }
        // create Product
        Product::create([
            "name" => "France Bread",
            "slug" => Str::slug(uniqid() . "France Bread"),
            "image" => "france_bread.jpg",
            "description" => "This French bread is awesome.",
            "sku" => "FR-BR-FRE-22",
            "price" => 5.99,
        ]);
        Product::create([
            "name" => "Samsung Galaxy",
            "slug" => Str::slug(uniqid() . "Samsung Galaxy"),
            "image" => "samsung_galaxy.jpg",
            "description" => "This phone is outstanding.",
            "sku" => "SS-GL-XY-22",
            "price" => 299.99,
        ]);
        Product::create([
            "name" => "Awesome Shoe",
            "slug" => Str::slug(uniqid() . "Awesome Shoe"),
            "image" => "shoe.jpg",
            "description" => "This shoe is something else!",
            "sku" => "AW-SH-XL-22",
            "price" => 59.99,
        ]);
        Product::create([
            "name" => "Normal Bag",
            "slug" => Str::slug(uniqid() . "Normal Bag"),
            "image" => "bag.jpg",
            "description" => "This bag is pretty normal",
            "sku" => "PP-LL-NO-22",
            "price" => 20.99,
        ]);

        // date with 3 days ahead of the current time
        $date = new DateTime("now", new DateTimeZone('Asia/Yangon'));
        $date->modify('+ 3 day');
        $date2 = new DateTime("now", new DateTimeZone('Asia/Yangon'));
        $date2->modify('+ 5 day');
        $leads = [
            0 => [
                "name" => "Jake",
                "value" => "4999.99",
                "source_id" => 3,
                "progress" => "prospect",
                "contact_id" => 1,
                "product_id" => 1,
                "quantity" => 60,
                "amount" => 359.4,
                "business_id" => 8,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            1 => [
                "name" => "Bob",
                "value" => "99.99",
                "source_id" => 2,
                "progress" => "follow up",
                "contact_id" => 2,
                "product_id" => 2,
                "quantity" => 100,
                "amount" => 29999,
                "business_id" => 5,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            2 => [
                "name" => "Selena",
                "value" => "499.99",
                "source_id" => 6,
                "progress" => "negotiation",
                "contact_id" => 3,
                "product_id" => 3,
                "quantity" => 100,
                "amount" => 5999,
                "business_id" => 1,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            3 => [
                "name" => "Bean",
                "value" => "4999.99",
                "source_id" => 3,
                "progress" => "prospect",
                "contact_id" => 1,
                "product_id" => 1,
                "quantity" => 60,
                "amount" => 359.4,
                "business_id" => 8,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            4 => [
                "name" => "Cane",
                "value" => "99.99",
                "source_id" => 2,
                "progress" => "follow up",
                "contact_id" => 2,
                "product_id" => 2,
                "quantity" => 100,
                "amount" => 29999,
                "business_id" => 5,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            5 => [
                "name" => "Maria",
                "value" => "499.99",
                "source_id" => 6,
                "progress" => "negotiation",
                "contact_id" => 3,
                "product_id" => 3,
                "quantity" => 100,
                "amount" => 5999,
                "business_id" => 1,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            6 => [
                "name" => "Kayne",
                "value" => "4999.99",
                "source_id" => 3,
                "progress" => "prospect",
                "contact_id" => 1,
                "product_id" => 1,
                "quantity" => 60,
                "amount" => 359.4,
                "business_id" => 8,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            7 => [
                "name" => "Sponge Bob",
                "value" => "99.99",
                "source_id" => 2,
                "progress" => "follow up",
                "contact_id" => 2,
                "product_id" => 2,
                "quantity" => 100,
                "amount" => 29999,
                "business_id" => 5,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            8 => [
                "name" => "Mr. White",
                "value" => "499.99",
                "source_id" => 6,
                "progress" => "negotiation",
                "contact_id" => 3,
                "product_id" => 3,
                "quantity" => 100,
                "amount" => 5999,
                "business_id" => 1,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            9 => [
                "name" => "Cool",
                "value" => "4999.99",
                "source_id" => 3,
                "progress" => "prospect",
                "contact_id" => 1,
                "product_id" => 1,
                "quantity" => 60,
                "amount" => 359.4,
                "business_id" => 8,
                "moderator_id" => 0,
                "admin_id" => 1,
            ],
            10 => [
                "name" => "Lisa",
                "value" => "99.99",
                "source_id" => 2,
                "progress" => "won",
                "contact_id" => 2,
                "product_id" => 2,
                "quantity" => 100,
                "amount" => 29999,
                "business_id" => 5,
                "moderator_id" => 1,
                "admin_id" => 0,
            ],
            11 => [
                "name" => "Jesse",
                "value" => "499.99",
                "source_id" => 6,
                "progress" => "won",
                "contact_id" => 3,
                "product_id" => 3,
                "quantity" => 100,
                "amount" => 5999,
                "business_id" => 1,
                "moderator_id" => 1,
                "admin_id" => 0,
            ],
        ];
        foreach ($leads as $key => $value) {
            Lead::create([
                "name" => $value["name"],
                "slug" => Str::slug(uniqid() . $value["name"]),
                "description" => $value["name"] . " sure is a gold mine!",
                "value" => $value["value"],
                "source_id" => $value["source_id"],
                "progress" => $value["progress"],
                "moderator_id" => $value["moderator_id"],
                "admin_id" => $value["admin_id"],
                "close_date" => $date->format('Y-m-d H:i:s'),
                "contact_id" => $value["contact_id"],
                "product_id" => $value["product_id"],
                "quantity" => $value["quantity"],
                "amount" => $value["amount"],
                "business_id" => $value["business_id"],
            ]);
        }
        // create activity
        Activity::create([
            "name" => "Talk to Jake",
            "slug" => Str::slug(uniqid() . "Talk to Jake"),
            "lead_id" => 1,
            "moderator_id" => 0,
            "admin_id" => 1,
            "description" => "Time to talk with Jake",
            "type" => "vc",
            "file" => "talk_to_jake2.txt",
            "file_name" => "talk_to_jake2.txt",
            "start_date" => $date->format('Y-m-d H:i:s'),
            "end_date" => $date2->format('Y-m-d H:i:s'),
        ]);
        Activity::create([
            "name" => "Lunch with Jake",
            "slug" => Str::slug(uniqid() . "Lunch with Jake"),
            "lead_id" => 1,
            "moderator_id" => 0,
            "admin_id" => 1,
            "description" => "Lets have lunch with Jake",
            "type" => "meeting",
            "file" => "lunch_with_jake.txt",
            "file_name" => "lunch_with_jake.txt",
            "start_date" => $date->format('Y-m-d H:i:s'),
            "end_date" => $date2->format('Y-m-d H:i:s'),
        ]);
        Activity::create([
            "name" => "Lets Bake Bob",
            "slug" => Str::slug(uniqid() . "Lets Bake Bob"),
            "lead_id" => 2,
            "moderator_id" => 0,
            "admin_id" => 1,
            "description" => "Lets bake with Bob",
            "type" => "meeting",
            "file" => "lets_bake_bob.txt",
            "file_name" => "lets_bake_bob.txt",
            "start_date" => $date->format('Y-m-d H:i:s'),
            "end_date" => $date2->format('Y-m-d H:i:s'),
        ]);
        Activity::create([
            "name" => "Lunch with Bob",
            "slug" => Str::slug(uniqid() . "Lunch with Bob"),
            "lead_id" => 2,
            "moderator_id" => 1,
            "admin_id" => 0,
            "description" => "Lets have a lunch with Bob",
            "type" => "meeting",
            "file" => "lunch_with_bob.txt",
            "file_name" => "lunch_with_bob.txt",
            "start_date" => $date->format('Y-m-d H:i:s'),
            "end_date" => $date2->format('Y-m-d H:i:s'),
        ]);
    }
}

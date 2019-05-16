<?php

use Illuminate\Database\Seeder;
use App\Models\ProductModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ProductsTableSeeder::class);
    }
}

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductModel::create([
            'product_name' => 'Samsung Galaxy S8',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Gold","OS":"Android Nougat"}',
            'sku'=>'andpho01',
            'price' => '15599',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
        ProductModel::create([
            'product_name' => 'OnePlus 5',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Black","OS":"Android Froyo"}',
            'sku'=>'andpho02',
            'price' => '7599',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
         ProductModel::create([
            'product_name' => 'Samsung Galaxy S9',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Yellow","OS":"Android Gingerbread"}',
            'sku'=>'andpho03',
            'price' => '15000',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
          ProductModel::create([
            'product_name' => 'OnePlus 4',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Green","OS":"Android Honeycomb"}',
            'sku'=>'andpho04',
            'price' => '4653',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
           ProductModel::create([
            'product_name' => 'Moto Z',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Cyan","OS":"Android Lollipop"}',
            'sku'=>'andpho05',
            'price' => '8769',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
         ProductModel::create([
            'product_name' => 'Moto D',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Orange","OS":"Android Lollipop"}',
            'sku'=>'andpho06',
            'price' => '8769',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
         ProductModel::create([
            'product_name' => 'iPhone 4S',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Gold","OS":"iOS 4.2.2"}',
            'sku'=>'iospho01',
            'price' => '2134',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
        ProductModel::create([
            'product_name' => 'iPhone 5 (A1428)',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Black","OS":"iOS 7"}',
            'sku'=>'iospho02',
            'price' => '3245',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
         ProductModel::create([
            'product_name' => 'iPhone 5c (A1507/A1516/A1529)',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Yellow","OS":"iOS 6"}',
            'sku'=>'iospho03',
            'price' => '12523',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
          ProductModel::create([
            'product_name' => 'iPad Air (Wi-Fi)',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Green","OS":"iOS 4.2.1"}',
            'sku'=>'iospho04',
            'price' => '234435',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
           ProductModel::create([
            'product_name' => 'iPad Air (Rev)',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Orange","OS":"iOS 4.1"}',
            'sku'=>'iospho05',
            'price' => '21533',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
         ProductModel::create([
            'product_name' => 'iPod touch (4th gen)',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'iOS Phones',
            'attributes' => '{"color":"Cyan","OS":"iOS 4.0.1"}',
            'sku'=>'iospho06',
            'price' => '32252',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
    }
}

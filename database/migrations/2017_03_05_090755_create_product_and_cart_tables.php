<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAndCartTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name')->unique();
            $table->string('product_category');//can be normalized based on actual req, for now keeping strings here directly
            $table->string('product_sub_category');//can be normalized based on actual req, for now keeping strings here directly
            $table->json('attributes');//attributes of the product like color, wieght, height, length etc
            $table->string('sku');
            $table->decimal('price', 10, 2);
            $table->integer('created_by')->length(10)->unsigned()->nullable();
            $table->integer('updated_by')->length(10)->unsigned()->nullable();
            $table->nullableTimestamps();
            $table->softDeletes() ; //datetime
        });
        
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->length(10);//Foreign Key to the user table(ASSUMES AND EXPECTS a USER TABLE)
            $table->integer('product_id')->length(10);//Foreign Key foreign key to the product table
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->unique(['user_id', 'product_id']);
            
            $table->foreign('user_id')->references('id')->on('users')
                            ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('product_id')->references('id')->on('products')
                            ->onUpdate('cascade')->onDelete('restrict');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('product');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdAndSubcategoryIdToWidgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widgets', function(Blueprint $table)
        {
            $table->integer('category_id')->unsigned()->after('slug');
            $table->integer('subcategory_id')->unsigned()->after('category_id');
        });
    }

    public function down()
    {
        Schema::table('products', function(Blueprint $table)
        {
           $table->dropColumn('category_id');
           $table->dropColumn('subcategory_id');
       });
    }
}

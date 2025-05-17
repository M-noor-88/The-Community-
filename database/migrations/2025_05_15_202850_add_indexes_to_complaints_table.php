<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToComplaintsTable extends Migration
{
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->index('status');               // Index on status column
            $table->index('complaint_category_id'); // Index on category_id
            $table->index('location_id');          // Index on location_id
        });
    }

    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['complaint_category_id']);
            $table->dropIndex(['location_id']);
            // $table->dropIndex(['user_id']);
        });
    }
}

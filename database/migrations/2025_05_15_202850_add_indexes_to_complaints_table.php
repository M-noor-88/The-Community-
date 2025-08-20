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
            $table->index('location_id');          // Index on location_id
        });
    }

    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex('complaints_status_index');
            $table->dropIndex('complaints_location_id_index');
            // $table->dropIndex(['user_id']);
        });
    }
}

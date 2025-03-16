<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipping_details', function (Blueprint $table) {
            $table->string('shipping_incoterm')->nullable()->after('total_cost');
            $table->string('port_name_or_city')->nullable()->after('shipping_incoterm');
        });
    }
    
    public function down(): void
    {
        Schema::table('shipping_details', function (Blueprint $table) {
            $table->dropColumn('shipping_incoterm');
            $table->dropColumn('port_name_or_city');
        });
    }
    
};

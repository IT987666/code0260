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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->change();
            $table->decimal('discount', 10, 2)->default(0)->change();
            $table->decimal('tax', 10, 2)->nullable()->change();
            $table->decimal('total', 10, 2)->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal')->change();
            $table->decimal('discount')->default(0)->change();
            $table->decimal('tax')->nullable()->change();
            $table->decimal('total')->change();
        });
    }
    
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->text('description')->nullable();           
             $table->text('companies_responsibilities')->nullable();           
             $table->text('customers_responsibilities')->nullable();           
           
             $table->string('code', 3); 
            $table->enum('stock_status', ['active', 'inactive']);
            $table->boolean ('featured')->default(false);
            
            $table->timestamp('adding_date')->nullable();
 
            $table->timestamps(); // هذا يضيف created_at و updated_at
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

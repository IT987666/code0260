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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('subtotal');
            $table->string('note')->nullable();
            $table->decimal('discount')->default(0);

            $table->decimal('tax')->nullable();
            $table->decimal('total');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
              $table->string('country')->nullable();
            $table->string('landmark')->nullable();
             $table->string('type')->default('home');
             $table->enum('status', [
                'ordered', 
                'delivered', 
                'canceled', 
                'offer_sent', 
                'offer_signed', 
                'downpayment_received', 
                'in_production', 
                'pending_final_payment', 
                'final_payment_received', 
                'shipped', 
                'cancelled'
            ])->default('ordered');
            
                        $table->boolean('is_shipping_different')->default(false);
            $table->date('delivered_date')->nullable();
            $table->date('canceled_date')->nullable();
            $table->json('images')->nullable();
            $table->text('extra')->nullable();
            $table->text('billing_info')->nullable();

            $table->string('reference_code')->nullable()->unique(); // كود الريفرنس للطلب، الآن يمكن أن يكون null

            $table->timestamps();
            $table->foreign('user_id')->references ('id')->on('users')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

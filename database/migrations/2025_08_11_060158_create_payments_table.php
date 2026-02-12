<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('txn_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->nullable(); // TXN_SUCCESS / TXN_FAILURE
            $table->text('response')->nullable(); // raw JSON/serialized response
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

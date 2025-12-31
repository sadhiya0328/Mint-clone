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
        //purpose:store bank/ credit accounts
        Schema::create('accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('plaid_item_id')->nullable();
        $table->string('name');
        $table->string('type'); // savings, checking, credit
        $table->decimal('balance', 12, 2)->default(0);
        $table->timestamps();
        });
        //One user → many accounts
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

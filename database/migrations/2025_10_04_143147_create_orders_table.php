<?php

use App\Enums\StatusOrderEnum;
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
            $table->text('notes')->nullable();
            $table->enum('status',
             [StatusOrderEnum::APPROVED,
              StatusOrderEnum::PENDING,
               StatusOrderEnum::REJECTED,
                StatusOrderEnum::COMPLETED])
                ->default(StatusOrderEnum::PENDING);
            $table->foreignId('provider_id')                
            ->constrained('users')                    
            ->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
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

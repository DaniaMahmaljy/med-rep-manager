<?php

use App\Enums\SampleUnitEnum;
use App\Models\Brand;
use App\Models\SampleClass;
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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(SampleClass::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity_available')->default(1);
            $table->tinyInteger('unit')->default(SampleUnitEnum::PIECE->value);
            $table->date('expiration_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};

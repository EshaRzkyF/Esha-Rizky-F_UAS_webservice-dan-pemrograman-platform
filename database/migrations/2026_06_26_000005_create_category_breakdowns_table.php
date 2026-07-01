<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analysis_report_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_breakdowns');
    }
};

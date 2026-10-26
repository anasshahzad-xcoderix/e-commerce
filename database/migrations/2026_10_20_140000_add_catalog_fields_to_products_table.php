<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('categories')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('stock');
            }

            if (Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->change();
            }

            if (Schema::hasColumn('products', 'art')) {
                $table->string('art')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

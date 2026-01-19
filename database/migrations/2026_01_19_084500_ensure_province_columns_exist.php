<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'province')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('province')->nullable()->after('status');
            });
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'province')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('province')->nullable()->after('address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'province')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('province');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'province')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('province');
            });
        }
    }
};

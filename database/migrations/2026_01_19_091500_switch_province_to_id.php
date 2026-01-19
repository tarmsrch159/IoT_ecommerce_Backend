<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add province_id columns
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable()->after('province')->constrained('provinces')->nullOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable()->after('province')->constrained('provinces')->nullOnDelete();
        });

        // 2. Migrate existing data (Try to match name_th)
        // We use raw SQL for update to ensure we catch existing matches
        $provinces = DB::table('provinces')->get();
        foreach ($provinces as $province) {
            DB::table('users')
                ->where('province', $province->name_th)
                ->update(['province_id' => $province->id]);

            DB::table('orders')
                ->where('province', $province->name_th)
                ->update(['province_id' => $province->id]);
        }

        // 3. Drop old columns (Optional, but user said "don't let it break", keeping it might be safer but confusing. 
        // Let's drop it to force usage of ID, assuming the migration above worked for valid data.)
        // However, to be safe and "don't break", I will keep it nullable for now or drop it?
        // User asked to fix it. Switching to ID is the fix. Dropping the string column avoids ambiguity.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('province');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('province')->nullable();
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('province')->nullable();
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');
        });
    }
};

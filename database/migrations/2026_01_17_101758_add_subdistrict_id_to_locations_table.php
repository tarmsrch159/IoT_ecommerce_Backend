<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // 1️⃣ เพิ่ม column ก่อน (nullable!)
            $table->integer('subdistrict_id')->nullable()->after('district');
        });

        // 2️⃣ (ชั่วคราว) อัปเดตข้อมูลเก่าให้ไม่เป็น NULL
        DB::table('locations')
            ->whereNull('subdistrict_id')
            ->update(['subdistrict_id' => 100101]); // ต้องมีจริงใน subdistricts

        Schema::table('locations', function (Blueprint $table) {
            // 3️⃣ ค่อย set NOT NULL
            $table->integer('subdistrict_id')->nullable(false)->change();

            // 4️⃣ ค่อยใส่ Foreign Key (อ้าง subdistrict_id)
            $table->foreign('subdistrict_id')
                ->references('subdistrict_id')
                ->on('subdistricts')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            //
            $table->dropForeign(['subdistrict_id']);
            $table->dropColumn('subdistrict_id');
        });
    }
};

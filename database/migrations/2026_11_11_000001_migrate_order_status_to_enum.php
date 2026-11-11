<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1 — Migrate existing order_status_id values into orders.status
        // Maps order_statuses.name_en (lowercase) → the enum key we want
        $map = [
            1 => 'pending',
            2 => 'confirmed',
            3 => 'processing',
            4 => 'shipped',
            5 => 'delivered',
            6 => 'cancelled',
        ];

        foreach ($map as $statusId => $statusValue) {
            DB::table('orders')
                ->where('order_status_id', $statusId)
                ->update(['status' => $statusValue]);
        }

        // Any orders with an unmapped / null order_status_id default to pending
        DB::table('orders')
            ->whereNotIn('status', array_values($map))
            ->update(['status' => 'pending']);

        // Step 2 — Drop the foreign key and the column
        Schema::table('orders', function (Blueprint $table) {
            // Drop FK if it exists (ignore if already gone)
            try {
                $table->dropForeign(['order_status_id']);
            } catch (\Throwable) {}

            $table->dropColumn('order_status_id');
        });

        // Step 3 — Drop the now-obsolete order_statuses table
        Schema::dropIfExists('order_statuses');
    }

    public function down(): void
    {
        // Recreate order_statuses table
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->boolean('default_status')->default(false);
            $table->unsignedTinyInteger('arrangement')->default(0);
        });

        $statuses = [
            ['id' => 1, 'name' => 'قيد الانتظار', 'name_en' => 'Pending',    'default_status' => 1, 'arrangement' => 1],
            ['id' => 2, 'name' => 'تم التأكيد',   'name_en' => 'Confirmed',  'default_status' => 0, 'arrangement' => 2],
            ['id' => 3, 'name' => 'قيد التجهيز',  'name_en' => 'Processing', 'default_status' => 0, 'arrangement' => 3],
            ['id' => 4, 'name' => 'تم الشحن',     'name_en' => 'Shipped',    'default_status' => 0, 'arrangement' => 4],
            ['id' => 5, 'name' => 'تم التسليم',   'name_en' => 'Delivered',  'default_status' => 0, 'arrangement' => 5],
            ['id' => 6, 'name' => 'ملغي',          'name_en' => 'Cancelled',  'default_status' => 0, 'arrangement' => 6],
        ];
        DB::table('order_statuses')->insert($statuses);

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_status_id')->nullable()->after('status');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->nullOnDelete();
        });

        // Restore order_status_id from status values
        $reverse = array_flip([1=>'pending',2=>'confirmed',3=>'processing',4=>'shipped',5=>'delivered',6=>'cancelled']);
        foreach ($reverse as $value => $id) {
            DB::table('orders')->where('status', $value)->update(['order_status_id' => $id]);
        }
    }
};

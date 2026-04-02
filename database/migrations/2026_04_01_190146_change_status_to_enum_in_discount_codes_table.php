<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Convert existing boolean values to enum strings before changing column type
        DB::statement("UPDATE discount_codes SET status = 'active' WHERE status = 1");
        DB::statement("UPDATE discount_codes SET status = 'inactive' WHERE status = 0");

        DB::statement("ALTER TABLE discount_codes MODIFY COLUMN status ENUM('active','inactive') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("UPDATE discount_codes SET status = 1 WHERE status = 'active'");
        DB::statement("UPDATE discount_codes SET status = 0 WHERE status = 'inactive'");

        DB::statement("ALTER TABLE discount_codes MODIFY COLUMN status TINYINT(1) NOT NULL DEFAULT 1");
    }
};

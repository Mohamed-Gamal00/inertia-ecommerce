<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'email'))       $table->string('email')->nullable()->unique()->after('name_en');
            if (!Schema::hasColumn('companies', 'password'))    $table->string('password')->nullable()->after('email');
            if (!Schema::hasColumn('companies', 'phone'))       $table->string('phone')->nullable()->after('password');
            if (!Schema::hasColumn('companies', 'description')) $table->text('description')->nullable()->after('phone');
            if (!Schema::hasColumn('companies', 'status'))      $table->enum('status', ['active', 'pending', 'suspended'])->default('pending')->after('description');
            if (!Schema::hasColumn('companies', 'is_vendor'))   $table->boolean('is_vendor')->default(false)->after('status');
            if (!Schema::hasColumn('companies', 'remember_token')) $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'phone', 'description', 'status', 'is_vendor', 'remember_token', 'created_at', 'updated_at']);
        });
    }
};

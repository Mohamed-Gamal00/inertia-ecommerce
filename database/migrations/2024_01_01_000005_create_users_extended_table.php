<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'family_name')) {
                $table->string('family_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable();
            }
        });

        if (!Schema::hasTable('users_verificationcodes')) {
            Schema::create('users_verificationCodes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('code')->nullable();
                $table->timestamp('verification_code_expires_at')->nullable();
                $table->string('compare_code')->nullable();
                $table->boolean('is_reset_password')->default(false);
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_tokens')) {
            Schema::create('user_tokens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('token');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_addresses')) {
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('address_title')->nullable();
                $table->string('first_name');
                $table->string('family_name')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('address')->nullable();
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
                $table->boolean('main_address')->default(false);
            });
        }

        if (!Schema::hasTable('forget_passwords')) {
            Schema::create('forget_passwords', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('code');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('forget_passwords');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('user_tokens');
        Schema::dropIfExists('users_verificationCodes');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'family_name', 'phone_number', 'address', 'image']);
        });
    }
};

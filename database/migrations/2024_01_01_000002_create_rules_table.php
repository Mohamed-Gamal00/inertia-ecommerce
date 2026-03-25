<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('rules')) {
            Schema::create('rules', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rule_abilities')) {
            Schema::create('rule_abilities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rule_id')->constrained('rules')->cascadeOnDelete();
                $table->string('ability');
                $table->string('type');
            });
        }

        if (!Schema::hasTable('admin_rule')) {
            Schema::create('admin_rule', function (Blueprint $table) {
                $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
                $table->foreignId('rule_id')->constrained('rules')->cascadeOnDelete();
                $table->primary(['admin_id', 'rule_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_rule');
        Schema::dropIfExists('rule_abilities');
        Schema::dropIfExists('rules');
    }
};

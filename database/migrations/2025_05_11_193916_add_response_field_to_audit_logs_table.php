<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('audit_logs', 'response')) {
            return;
        }
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->json('response')->after('request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('audit_logs', 'response')) {
            return;
        }
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn('response');
        });
    }
};

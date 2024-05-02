<?php

use Src\Voting\Association;
use Src\Voting\VotingSession;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('principal_id')->nullable()->after('id');
        });

        Schema::table('associations', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('principal_id');
        });

        Schema::table('associations', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->change();
        });
    }
};

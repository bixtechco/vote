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
        Schema::table('voting_session_members', function (Blueprint $table) {
            $table->string('block_index')->nullable()->after('votes');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voting_session_members', function (Blueprint $table) {
            $table->dropColumn('block_index');
        });
    }
};

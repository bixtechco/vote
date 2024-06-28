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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('association_id');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::table('voting_sessions', function (Blueprint $table) {
            $table->json('winner_qty')->after('winner_ids');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
        Schema::table('voting_sessions', function (Blueprint $table) {
            $table->dropColumn('winner_qty');
        });
    }
};

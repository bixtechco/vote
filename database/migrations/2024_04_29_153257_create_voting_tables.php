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
        Schema::create('associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->unsignedInteger('status')->default(Association::STATUS_ACTIVE);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('association_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_admin')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('voting_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('association_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('year')->nullable();
            $table->json('role_candidate_ids')->comment('eg. {"President": [1, 2, 3]}');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->json('winner_ids')->nullable()->comment('eg. {"President": 1}');
            $table->unsignedBigInteger('created_by');
            $table->unsignedInteger('status')->default(VotingSession::STATUS_DRAFT);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('voting_session_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('voting_session_id');
            $table->unsignedBigInteger('user_id');
            $table->json('votes')->nullable()->comment('eg. {"President": "1"}');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
        Schema::dropIfExists('association_members');
        Schema::dropIfExists('association_roles');
        Schema::dropIfExists('voting_sessions');
        Schema::dropIfExists('voting_session_members');
    }
};

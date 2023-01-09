<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(User::class, 'staff_id')->nullable();
            $table->string('ticket_code', 50)->nullable();
            $table->string('ticket_title', 100)->nullable();
            $table->string('ticket_status', 50)->nullable();
            $table->string('ticket_priority', 50)->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};

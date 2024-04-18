<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_request', function (Blueprint $table) {
            $table->primary(['user', 'task']);
            $table->bigInteger('user');
            $table->bigInteger('task');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->bigInteger('createdBy');
            $table->bigInteger('assignedTo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('task_request');
        
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('createdBy');
            $table->dropColumn('assignedTo');
        });
    }
};

<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('priority')->default(Task::PRIORITY_LEVEL_LOW);
            $table->boolean('completed')->default(Task::NOT_COMPLETED);
            $table->timestamps();
            $table->dateTime('duedate')->nullable();
            $table->integer('position')->nullable();
            $table->softDeletes();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

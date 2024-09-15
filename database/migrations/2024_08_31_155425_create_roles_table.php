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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Role name, e.g., Admin, User
            $table->boolean('can_add_activity')->default(false);
            $table->boolean('can_add_admin')->default(false);
            $table->boolean('can_update_user_role')->default(false);
            $table->boolean('can_create_activity')->default(false);
            $table->boolean('can_approve_activity')->default(false);
            $table->boolean('can_delete_activity')->default(false);
            $table->boolean('can_edit_activity')->default(false);
            $table->boolean('can_delete_admin')->default(false);
            $table->timestamps(); // Includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

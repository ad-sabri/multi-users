<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_garagiste')->default(false);
        });

        // Mettez à jour les utilisateurs qui existent dans la table garagistes
        $garagisteUserIds = DB::table('garagistes')->pluck('user_id');
        DB::table('users')->whereIn('id', $garagisteUserIds)->update(['is_garagiste' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_garagiste');
        });
    }
};

<?php

use Carbon\Factory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AddCreatedByToProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $user =User::factory()->create([
            'name'=> 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make("password")
        ]);

        Schema::table('products', function (Blueprint $table) use ($user){
            $table->unsignedBigInteger('created_by')->default($user->id);
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}

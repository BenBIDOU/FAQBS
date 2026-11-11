<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Informations personnelles
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('telephone')->nullable();
            $table->string('ville_bs')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('France');
            
            // Informations professionnel/bénévole
            $table->string('function')->nullable();
            $table->string('skills')->nullable();
            $table->text('bio')->nullable();
            
            // Préférences
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            
            // Photos et documents
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            
            // Dates importantes
            $table->date('birth_date')->nullable();
            $table->date('membership_start')->nullable();
            $table->date('membership_end')->nullable();
            
            // Rôles et permissions (en plus de ceux dans users)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            
            // Champ pour notes internes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index('user_id');
            $table->index('is_active');
            $table->index('is_verified');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};

<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(25)
            ->has(Article::factory()->count(3))
            ->create();


        // Compte de test
        User::create([
            'name' => 'testuser',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}

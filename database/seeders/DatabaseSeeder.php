<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\News;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tech = Category::create(['name' => 'Tecnologia']);
        $sports = Category::create(['name' => 'Esportes']);

        News::create([
            'title' => 'Nova versão do Laravel lançada',
            'content' => 'A comunidade de PHP está em festa com as novas features.',
            'category_id' => $tech->id,
        ]);

        News::create([
            'title' => 'Campeonato regional de futebol',
            'content' => 'O time da casa venceu por 3 a 1 na final de domingo.',
            'category_id' => $sports->id,
        ]);
    }
}

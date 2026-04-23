<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['nombre' => 'Smartphones']);
        Categoria::create(['nombre' => 'Portatiles']);
        Categoria::create(['nombre' => 'Tablets']);
        Categoria::create(['nombre' => 'Audio']);
        Categoria::create(['nombre' => 'Televisores']);
        Categoria::create(['nombre' => 'Electrodomesticos']);
        Categoria::create(['nombre' => 'Fotografia']);
        Categoria::create(['nombre' => 'Accesorios']);
        Categoria::create(['nombre' => 'Videojuegos']);
    }
}

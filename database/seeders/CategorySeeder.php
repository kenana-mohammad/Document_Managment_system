<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'mimeType'=>'pdf',


        ]);
        Category::create([
            'mimeType'=>'xlsx',


        ]);
          Category::create([
            'mimeType'=>'txt',

        ]);
        Category::create([
            'mimeType'=>'docx',
        ]);
    }
}

<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('categorias')->insert([
            'nombre' => 'Restaurant',
            'slug' => Str::slug('Restaurant'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Cafe',
            'slug' => Str::slug('Cafe'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Hotel',
            'slug' => Str::slug('Hotel'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Hospital',
            'slug' => Str::slug('Hospital'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Gimnacio',
            'slug' => Str::slug('Gimnacio'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Doctor',
            'slug' => Str::slug('Doctor'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}

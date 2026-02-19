<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      \App\Models\Band::create([
        'name' => 'The UnderTones',
        'name_kana' => 'アンダートーンズ',
        'genre' => 'Alternative Rock',
        'formation' => '4ピース',
        'label' => 'Independent',
        'formed_at' => '2020-01-01',
        'area' => '下北沢',
        'youtube_url' => 'Mfy1HCD2sTk',
      ]);

      \App\Models\Band::create([
        'name' => 'ギターラビット',
        'name_kana' => 'ギターラビット',
        'genre' => 'Punk',
        'formation' => '3ピース',
        'label' => 'None',
        'formed_at' => '2022-05-10',
        'area' => '高円寺',
        'youtube_url' => 'khE2qYFHAk8',
    ]);

    \App\Models\Band::create([
        'name' => 'さばもぐ',
        'name_kana' => 'サバモグ',
        'genre' => 'ロック',
        'formation' => '1',
        'label' => 'None',
        'formed_at' => '2026-6-15',
        'area' => '宮城',
        'youtube_url' => 'CWZ0lTUs5Mk',
    ]);
    }
}

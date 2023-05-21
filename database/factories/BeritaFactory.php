<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_channel' => mt_rand(1, 3),
            'penulis' => $this->faker->name(),
            // 'oleh' => $this->faker->name(),
            'wartawan' => $this->faker->name(),
            'id_wartawan' => 1,
            'tanggal_tayang' => $this->faker->dateTimeBetween('-1 month', now()),
            'waktu' => $this->faker->time('H:i'),
            'isi' => $this->faker->paragraphs(10),
            'judul' => $this->faker->words(mt_rand(10, 15), true),
            'slug' => $this->faker->slug(),
            'isi' => $this->faker->paragraph(),
            'headline' => mt_rand(0, 1),
            'publish' => 1,
            'tag' => $this->faker->word(),
            'gambar_detail' => $this->faker->url(),
            'caption' => $this->faker->words(3, true),
            'counter' => mt_rand(1, 1000),

        ];
    }
}

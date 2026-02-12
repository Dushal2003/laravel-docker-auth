<?php 

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $title = $this->faker->words(3, true);

        return [
    'title' => ucfirst($title),
    'slug' => \Illuminate\Support\Str::slug($title) . '-' . $this->faker->unique()->numberBetween(100, 999),
    'category' => $this->faker->randomElement(['Electronics', 'Sportswear', 'Gadgets', 'Books']),
    'price' => $this->faker->numberBetween(500, 10000),
    'discount' => $this->faker->optional()->randomElement(['5%', '10%', '15%', '20%']),
    'image' => 'https://via.placeholder.com/300x200.png?text=' . urlencode($title),
    'Descripation' => $this->faker->paragraph(), // ✅ Add this
    'Certificate' => fake()->word(), // or some realistic placeholder

];

    }
}

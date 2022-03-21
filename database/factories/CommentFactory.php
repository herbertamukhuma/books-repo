<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
    	return [
    	    'book_isbn' => $this->faker->isbn10(),
            'comment_text' => $this->faker->sentence,
            'commenter_ip' => $this->faker->ipv4()
    	];
    }
}

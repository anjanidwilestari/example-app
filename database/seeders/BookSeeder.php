<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('books')->insert([
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'A novel about the American dream and its inevitable corruption.',
                'image_path' => 'images/great_gatsby.jpg',  // Path to image if available
                'video_path' => 'videos/great_gatsby_trailer.mp4',  // Path to video if available
                'audio_path' => 'audio/great_gatsby_excerpt.mp3',  // Path to audio if available
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'A dystopian novel set in a totalitarian society controlled by Big Brother.',
                'image_path' => 'images/1984.jpg',
                'video_path' => 'videos/1984_trailer.mp4',
                'audio_path' => 'audio/1984_excerpt.mp3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A novel about racial inequality and the loss of innocence in the American South.',
                'image_path' => 'images/to_kill_a_mockingbird.jpg',
                'video_path' => 'videos/to_kill_a_mockingbird_trailer.mp4',
                'audio_path' => 'audio/to_kill_a_mockingbird_excerpt.mp3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'description' => 'A romantic novel that deals with the issues of marriage, wealth, and society in early 19th-century England.',
                'image_path' => 'images/pride_and_prejudice.jpg',
                'video_path' => 'videos/pride_and_prejudice_trailer.mp4',
                'audio_path' => 'audio/pride_and_prejudice_excerpt.mp3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Moby Dick',
                'author' => 'Herman Melville',
                'description' => 'A novel about the obsessive quest of Captain Ahab for revenge on Moby Dick, the giant white whale.',
                'image_path' => 'images/moby_dick.jpg',
                'video_path' => 'videos/moby_dick_trailer.mp4',
                'audio_path' => 'audio/moby_dick_excerpt.mp3',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::create([
            'title' => 'How organized was the lecture in terms of the time frame and assessment and access to materials?'
        ]);
        Question::create([
            'title' => 'How well did the teacher communicate his/her subject to students?'
        ]);
        Question::create([
            'title' => 'How fair was the course assessment method?'
        ]);
    }
}

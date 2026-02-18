<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['question' => 'Ibu kota Indonesia?', 'answer' => 'JAKARTA'],
            ['question' => '2 + 2 = ?', 'answer' => '4'],
            ['question' => 'Warna langit?', 'answer' => 'BIRU'],
            ['question' => 'Planet terdekat dengan matahari?', 'answer' => 'MERKURIUS'],
            ['question' => 'Hewan berkaki empat yang suka menggonggong?', 'answer' => 'ANJING'],
            ['question' => '5 x 5 = ?', 'answer' => '25'],
            ['question' => 'Ibu kota Jepang?', 'answer' => 'TOKYO'],
            ['question' => 'Buah berwarna kuning melengkung?', 'answer' => 'PISANG'],
            ['question' => 'Hari setelah Senin?', 'answer' => 'SELASA'],
            ['question' => '10 - 3 = ?', 'answer' => '7'],
            ['question' => 'Hewan raja hutan?', 'answer' => 'SINGA'],
            ['question' => 'Warna daun?', 'answer' => 'HIJAU'],
            ['question' => 'Bahasa yang digunakan di Perancis?', 'answer' => 'PERANCIS'],
            ['question' => 'Jumlah hari dalam seminggu?', 'answer' => '7'],
            ['question' => 'Organ tubuh untuk melihat?', 'answer' => 'MATA'],
            ['question' => '3 x 4 = ?', 'answer' => '12'],
            ['question' => 'Benua terbesar di dunia?', 'answer' => 'ASIA'],
            ['question' => 'Hewan yang hidup di air dan punya sirip?', 'answer' => 'IKAN'],
            ['question' => 'Warna darah?', 'answer' => 'MERAH'],
            ['question' => '100 / 10 = ?', 'answer' => '10'],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}

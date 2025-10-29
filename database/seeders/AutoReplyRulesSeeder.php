<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\AutoReplyRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutoReplyRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $rules = [
           [
               'keyword' => 'hello',
               'reply' => 'Hi there! How can I assist you today?',
               'status' => STATUS_ACTIVE,
           ],
           [
               'keyword' => 'pricing',
               'reply' => 'Our pricing details can be found on our website at www.example.com/pricing.',
               'status' => STATUS_ACTIVE,
           ],
           [
               'keyword' => 'support',
               'reply' => 'For support, please email us at support@example.com.',
               'status' => STATUS_ACTIVE,
           ],
       ];

       foreach ($rules as $rule) {
           AutoReplyRule::updateOrCreate([
               'keyword' => $rule['keyword'],
           ], $rule);
       }
    }
}

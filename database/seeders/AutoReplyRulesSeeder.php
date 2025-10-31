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
        [
         'keyword' => 'hours',
         'reply' => 'Our business hours are 9am to 5pm, Monday to Friday.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'location',
         'reply' => 'We are located at 123 Main Street, Cityville.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'contact',
         'reply' => 'You can contact us at (123) 456-7890.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'refund',
         'reply' => 'Refunds are processed within 5-7 business days.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'delivery',
         'reply' => 'Delivery usually takes 3-5 business days.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'order status',
         'reply' => 'You can check your order status in your account dashboard.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'cancel order',
         'reply' => 'To cancel your order, please visit your orders page or contact support.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'payment methods',
         'reply' => 'We accept Visa, MasterCard, PayPal, and bank transfer.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'discount',
         'reply' => 'Check our website for the latest discounts and offers.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'newsletter',
         'reply' => 'Subscribe to our newsletter for updates and promotions.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'account',
         'reply' => 'You can manage your account settings in your profile page.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'reset password',
         'reply' => 'To reset your password, click on "Forgot Password" at login.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'shipping',
         'reply' => 'We offer free shipping on orders over $50.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'track order',
         'reply' => 'Track your order using the tracking link sent to your email.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'feedback',
         'reply' => 'We appreciate your feedback! Please fill out our feedback form.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'careers',
         'reply' => 'Visit our careers page to see current job openings.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'faq',
         'reply' => 'Visit our FAQ page for answers to common questions.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'about',
         'reply' => 'Learn more about us on our About page.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'terms',
         'reply' => 'Read our terms and conditions at www.example.com/terms.',
         'status' => STATUS_ACTIVE,
        ],
        [
         'keyword' => 'privacy',
         'reply' => 'Our privacy policy is available at www.example.com/privacy.',
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

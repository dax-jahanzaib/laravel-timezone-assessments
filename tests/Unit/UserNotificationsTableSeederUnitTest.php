<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserNotificationsTableSeederUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function testSeederInsertsData()
    {
        // Run the seeder
        Artisan::call('db:seed', ['--class' => 'UserNotificationsTableSeeder']);

        // Assert that the data was inserted into the database
        $this->assertDatabaseCount('user_notifications', User::count() * 2); // Assuming two notifications per user

        // Additional assertions if needed
        // For example, you can check if the notification messages or other details are correct
        $userNotifications = UserNotification::all();

        foreach ($userNotifications as $notification) {
            $this->assertNotNull($notification->user_id);
            $this->assertNotNull($notification->scheduled_at);
            $this->assertNotNull($notification->frequency);
            $this->assertNotNull($notification->notification_message);
        }
    }
}

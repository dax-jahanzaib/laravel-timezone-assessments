<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class UserNotificationsTableSeederTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if the seeder correctly inserts data.
     *
     * @return void
     */
    public function testSeederInsertsData()
    {
        // Run the seeder
        Artisan::call('db:seed', ['--class' => 'UserNotificationsTableSeeder']);

        // Assert that the data was inserted into the database
        $this->assertDatabaseCount('user_notifications', User::count() * 2); // Assuming two notifications per user
    }

    /**
     * Test if notifications are triggered as expected.
     *
     * @return void
     */
    public function testNotificationsAreTriggered()
    {
        // Assuming you have some logic to trigger notifications in your application,
        // you can call that logic here.

        // Example: Trigger notifications for all users
        $users = User::all();
        foreach ($users as $user) {
            // Assuming there is some logic to trigger notifications for each user
            // You might need to adjust this part based on your application's notification logic
            $user->triggerNotifications(); 
        }

        // Assert that the expected number of notifications are in the database
        $this->assertDatabaseCount('user_notifications', User::count() * 2); // Assuming two notifications per user
    }
}

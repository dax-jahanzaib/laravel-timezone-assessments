<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserNotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Ensure that the system correctly handles user-specific time zones when scheduling and displaying notifications.
            foreach (range(1, 2) as $index) { 
                $userTimeZone = $user->timezone;
                // Set the application's time zone to the user's time zone to Generate a scheduled time in the user's time zone
                config(['app.timezone' => $userTimeZone]);

                $scheduledTime = Carbon::now()->addDays(rand(1, 7))->setTimezone($userTimeZone)->format('H:i');

                $notificationMessage = "Hello {$user->name},\n"
                    . "This is a notification for you. Your email address is: {$user->email}.\n"
                    . "You have a scheduled event at {$scheduledTime} in your local timezone ({$userTimeZone}).\n"
                    . "Thank you for using our notification system.\n"
                    . "Best regards,\n"
                    . "[Your Company Name]";

                DB::table('user_notifications')->insert([
                    'user_id' => $user->id,
                    'scheduled_at' => $scheduledTime,
                    'frequency' => fake()->randomElement(['daily', 'weekly', 'monthly', 'custom']),
                    'notification_message' => $notificationMessage,
                ]);
            }
        }
    }
}

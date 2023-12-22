<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifications = DB::table('user_notifications')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($notifications as $notification) {

            // Perform the action (log, send notification, etc.)
            $this->logNotification($notification);

            // Update the next scheduled time based on the frequency
            $this->updateNextScheduledTime($notification);
        }
    }

    private function logNotification($notification)
    {
        // Perform the action you want (e.g., log to a file, send an email)
        // You can access notification details like $notification->user_id, $notification->notification_message, etc.
        // Example: Log to laravel.log
        Log::info("Scheduled Notification: {$notification->notification_message}");
    }

    private function updateNextScheduledTime($notification)
    {
        $frequency = $notification->frequency;

        switch ($frequency) {
            case 'daily':
            $nextScheduledTime = Carbon::parse($notification->scheduled_at)->addDay();
            break;
            case 'weekly':
                $nextScheduledTime = Carbon::parse($notification->scheduled_at)->addWeek();
            break;
            case 'monthly':
                $nextScheduledTime = Carbon::parse($notification->scheduled_at)->addMonth();
            break;
            default:
                $nextScheduledTime = Carbon::parse($notification->scheduled_at)->addDay();
            break;
        }

        DB::table('user_notifications')
            ->where('id', $notification->id)
            ->update(['scheduled_at' => $nextScheduledTime]);
    }
}

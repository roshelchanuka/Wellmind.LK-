<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\EmailReminder;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 8:00 AM engagement reminders to inactive users (2 days inactivity)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting reminder process...');

        // Find users who haven't logged in for 2 days
        // We only send one reminder if they haven't received one in the last 2 days to avoid spamming
        $inactiveUsers = User::where('last_login', '<', Carbon::now()->subDays(2))
            ->where('is_verified', 1)
            ->get();

        $sentCount = 0;

        foreach ($inactiveUsers as $user) {
            // Check if we've already sent a reminder today to this user
            $alreadySent = EmailReminder::where('user_id', $user->id)
                ->where('created_at', '>', Carbon::today())
                ->exists();

            if (!$alreadySent) {
                try {
                    // 1. Send the Mail
                    Mail::to($user->email)->send(new ReminderMail());

                    // 2. Log in database
                    EmailReminder::create([
                        'user_id' => $user->id,
                        'reminder_type' => '2-day inactivity',
                        'reminder_time' => Carbon::now(),
                        'is_sent' => 1
                    ]);

                    $sentCount++;
                    $this->info("Reminder sent to: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send to {$user->email}: " . $e->getMessage());
                    
                    // Log failed attempt
                    EmailReminder::create([
                        'user_id' => $user->id,
                        'reminder_type' => '2-day inactivity',
                        'reminder_time' => Carbon::now(),
                        'is_sent' => 0
                    ]);
                }
            }
        }

        $this->info("Reminder process finished. Sent: $sentCount");
    }
}

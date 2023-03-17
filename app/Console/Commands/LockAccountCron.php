<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LockAccountCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lock-account:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command will automatically lock pending (unverified users)  account after 1 month ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('this is a test cron is working fine!');

        $users = User::unverified()->get();
        Log::info('users count:'.$users->count());

        foreach ($users as $unverifiedUser) {
            $userCreated = $unverifiedUser->created_at->toDateString();
            $userCreateDateParse = Carbon::parse($userCreated);

            $lastMonthDate = now()->subMonth()->toDateString();
            $lastMonthDateParse = Carbon::parse($lastMonthDate);

            $result = $userCreateDateParse->eq($lastMonthDateParse);

            if ($result) {
                $unverifiedUser->update([
                    'is_locked' => true,
                ]);

                Log::info('user locked:'.$unverifiedUser);
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Repositories\UserRepository;
use App\Services\EmailWriterService;
use App\Services\UserEventSyncService;
use Illuminate\Console\Command;

class SyncEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-events {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync calendar events for users';

    /**
     * Execute the console command.
     */
    public function handle(
        UserRepository $userRepository,
        UserEventSyncService $userEventSyncService,
        EmailWriterService $emailWriterService,
    ): void {
        $dateString = $this->argument('date');
        $date = $dateString ? new \DateTimeImmutable($dateString) : new \DateTimeImmutable('now');
        foreach ($userRepository->findAll() as $user) {
            $userEventSyncService->sync($user);
            $json = $emailWriterService->makeEmail($user, $date);
            Email::firstOrCreate([
                'scheduled_for' => $date->format('Y-m-d'),
                'user_id' => $user->id
            ], [
                'data' => json_encode($json) // json_encode is only needed because of sqlite
            ]);
        }
    }
}

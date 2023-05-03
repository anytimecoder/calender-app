<?php

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use App\Services\UserEventSyncService;
use Illuminate\Console\Command;

class SyncEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync calendar events for users';

    /**
     * Execute the console command.
     */
    public function handle(UserRepository $userRepository, UserEventSyncService $userEventSyncService): void
    {
        foreach ($userRepository->findAll() as $user) {
            $userEventSyncService->sync($user);
        }
    }
}

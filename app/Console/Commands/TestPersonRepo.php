<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Services\UserEventSyncService;
use Illuminate\Console\Command;

class TestPersonRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-repo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test person repo';

    /**
     * Execute the console command.
     */
    public function handle(PersonRepository $repo): void
    {
        /** @var Person $person */
        $person = $repo->findById(1);
        $result = $repo->findMetWithUsersCount($person, 'stephan@usergems.com');
        echo('MEETING COUNT: ' . json_encode($result) . PHP_EOL);
    }
}

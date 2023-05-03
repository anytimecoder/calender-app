<?php

namespace App\Console\Commands;

use App\Interfaces\PersonApiInterface;
use App\Repositories\UserRepository;
use App\Services\UserEventSyncService;
use Illuminate\Console\Command;

class FetchPerson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-person {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches a person from person api or cache';

    /**
     * Execute the console command.
     */
    public function handle(PersonApiInterface $personApi): void
    {
        $email = $this->argument('email');
        if (!$email) {
            return;
        }
        $personApi->getPerson($email);
    }
}

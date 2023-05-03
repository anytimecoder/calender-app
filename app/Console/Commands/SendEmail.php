<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test person repo';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $unsentEmails = Email::where('sent_at', null)->get();
        /** @var Email $email */
        foreach ($unsentEmails as $email) {
            // TODO send email
            $email->sent_at = now();
            $email->save();
        }
    }
}

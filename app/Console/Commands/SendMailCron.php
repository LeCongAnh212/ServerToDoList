<?php

namespace App\Console\Commands;

use App\Services\User\HandleSendMail;
use App\Services\User\SendMailToUser;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendMailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendMail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {
        resolve(HandleSendMail::class)->handle();

        $this->info('sendMail:cron Cummand Run successfully!');
    }
}

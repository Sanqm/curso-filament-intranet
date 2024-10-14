<?php

namespace App\Console\Commands;

use App\Mail\HolidayPending;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() //en esta función se implementa la lógica de las acciones del envio de mails
    {
        $user = User::find(1);
        Mail::to($user)->send(new HolidayPending()); // docularevel permite mandar un mail 
    }
}

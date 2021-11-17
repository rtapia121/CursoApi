<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NewsletterNotificaion;
use Illuminate\Console\Command;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newslatter {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->argument('emails');
        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();

        if ($count) {
            $this->output->progressStart();

            $builder->whereNotNull('email_verified_at')
                ->each(function (User $user) {
                    $user->notify(new NewsletterNotificaion());
                    $this->output->progressAdvance();
                });

            $this->info("Se enviaron {$count} correos");
            $this->output->progressFinish();
        }
        $this->info("No se enviaron correos");
    }
}

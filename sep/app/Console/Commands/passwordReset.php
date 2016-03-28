<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\cronResetPassword;
use Mail;

class passwordReset extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'passwordReset:cron';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send password resets as emails';

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
	 * @return mixed
	 */
	public function fire()
	{
		$tasks = cronResetPassword::all();
		foreach( $tasks as $task ) {
				Mail::send('mailtemplate/passwordreset', ['name'=> $task->name,'pass'=> $task->password], function ($m) use ($task) {
					$m->from('hello@app.com', 'Your Application');
					$m->to($task->email, $task->name)->subject('New Password!');
				});
				$task->delete();
		}
		$this->info('Password reset emails were sent successfully!');
	}

}

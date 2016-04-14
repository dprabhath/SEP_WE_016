<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\cronResetPassword;
use App\deletedUser;
use App\disabledUser;
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
				Mail::queue('mailtemplate/passwordreset', ['name'=> $task->name,'pass'=> $task->password], function ($m) use ($task) {
					$m->from('daemon@mail.altairsl.us', 'Native Physician');
					$m->to($task->email, $task->name)->subject('New Password!');
				});
				$task->delete();
		}
		$deletedUsers=deletedUser::all();
		foreach( $deletedUsers as $deletedUser ) {
				Mail::queue('mailtemplate/accountDelete', ['name'=> $deletedUser->name], function ($m) use ($deletedUser) {
					$m->from('daemon@mail.altairsl.us', 'Native Physician');
					$m->to($deletedUser->email, $deletedUser->name)->subject('Your Account Removed!');
				});
				$deletedUser->delete();
		}
		$disabledUsers=disabledUser::all();
		foreach( $disabledUsers as $disabledUser ) {
				Mail::queue('mailtemplate/accountDeactivate', ['name'=> $disabledUser->name], function ($m) use ($disabledUser) {
					$m->from('daemon@mail.altairsl.us', 'Native Physician');
					$m->to($disabledUser->email, $disabledUser->name)->subject('Your Account Disabled!');
				});
				$disabledUser->delete();
		}
		$this->info('Password reset emails were sent successfully!');

	}

}

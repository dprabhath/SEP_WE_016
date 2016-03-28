<?php namespace App\Console\Commands;
use App\smslimit;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class smsReset extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'smsReset:cron';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reset the smslimit table';

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
		//
		$tasks = smslimit::all();
		foreach( $tasks as $task ) {
				$task->delete();
		}
		$this->info('Smslimit table cleard!');
	}
}

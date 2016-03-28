<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\passwordReset',
		'App\Console\Commands\smsReset',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//$schedule->command('inspire')->hourly();
		$schedule->command('passwordReset:cron')->cron('*/2 * * * *')->sendOutputTo(storage_path('logs/cronPasswordReset.log'));
		$schedule->command('smsReset:cron')->cron('*/3 * * * *')->sendOutputTo(storage_path('logs/cronsmsReset.log'));

	}

}

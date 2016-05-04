<?php namespace App\Console\Commands;
use App\spam;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;
class spams extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'spams:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the spam table';

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
        $dt = Carbon::now('Asia/Colombo');
        $spams=spam::get();
        foreach ($spams as $spam) {
            $dt2 = new Carbon($spam->updated_at,'Asia/Colombo');
            $val=$dt2->diffInMinutes($dt);
            if($val>6){
                $spam->delete();
            }
            
        }
        $this->info('spam table cleard!');
    }
}
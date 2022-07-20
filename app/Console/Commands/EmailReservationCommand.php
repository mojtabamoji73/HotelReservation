<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Libraries\Notifications;
use App\Notifications\Reservation;
use App\Models\Booking;

class EmailReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:notify 
    {count : the number of booking to retrieve}
    {--dry-run= : To have this command do no actual work.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify reservation holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Notifications $notify)
    {
        $this->notify = $notify;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $answer = $this->choice('what service should we use?',['sms','email'],'email');
        var_dump('$answer'); 
        $count = $this->argument('count');
        if(!is_numeric($count)){
            $this->alert('the count must be a number!');
            return 1;

        }
        $booking = Booking::with(['room.roomType','users'])->limit($count)->get();
        $this->info(sprintf('The number of bookings to alert for is: %d',$booking->count()));
        $bar = $this->output->createProgressBar($booking->count());
        $bar->start();
        foreach($booking as $bookings){
           $this->processBooking($bookings);
         

            $bar->advance();

        }
        $bar->finish();
        $this->comment('command completed');

    }

    public function processBooking($bookings)
    {


        if($this->option('dry-run')){

            $this->info('Would process booking');

        }else{

           // $this->notify->send();
            $bookings->notify(new Reservation('mart martin'));
    
        }


    }
}

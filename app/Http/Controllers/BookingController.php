<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessBookingJob;
use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\support\facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings =booking::with(['room.roomType','users:name'])->paginate('2');

        return view('booking.index')
        ->with('bookings',$bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $users=DB::table('users')->get()->pluck('name','id')->prepend('none');
        $rooms=DB::table('rooms')->get()->pluck('number','id')->prepend('Select Room');
        return view('booking.create')
        ->with('users',$users)
        ->with('rooms',$rooms)
        ;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $booking = Booking::create($request->input());

        $booking->users()->attach($request->input('user_id'));
       

       
        return redirect('/booking');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(booking $booking)
    {
        return view('booking.show' , ['booking'=> $booking]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(booking $booking)
    {
        $users=DB::table('users')->get()->pluck('name','id')->prepend('none');
        $rooms=DB::table('rooms')->get()->pluck('number','id')->prepend('Select Room');
        $bookingsUser=DB::table('bookings_users')->where('booking_id',$booking->id)->first();
        return view('booking.edit')
        ->with('users',$users)
        ->with('rooms',$rooms)
        ->with('booking',$booking)
        ->with('bookingsUser',$bookingsUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, booking $booking)
    {
        (ProcessBookingJob::dispatch($booking));

        $validatedData=$request->validate([
            'start' => 'required|date',
              'end' => 'required|date',
              'room_id' => 'required|exists:rooms,id',
              'user_id' => 'required|exists:users,id',
              'is_paid' => 'nullable',
              'is_reservation' => 'required',
              'notes' => 'present',




        ]);
       $booking->fill($validatedData);
        $booking->save();

        $booking->users()->sync($validatedData['user_id']);
    
 
 
 

         return redirect('/booking');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(booking $booking)
    {
        $booking->users->detach();
        $booking->delete();
        return redirect('/booking');
    }
}

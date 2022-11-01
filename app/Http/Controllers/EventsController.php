<?php
  
namespace App\Http\Controllers;
  
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $events = Event::latest()->paginate(5);
    
        return view('events.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);   
        }
    
        $startDate = $request->get('date'); 
        $endDate = $parts = explode('-', now());
        $years = $parts[0] - $startDate ;

        $event = new Event([
            'name' => $request->get('name'),
            'date' => $request->get('date'),
            'image' => $profileImage,
            'description' => $request->get('description'),
            'years' => $years,
        ]);

        $event->save();
     
        return redirect()->route('events.index')
                        ->with('success','Event created successfully.');
    }


    
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show',compact('event'));
    }
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        return view('events.edit',compact('event'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',       
        ]);
  
        $event = Event::find($id);
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
           
        }else{
            $profileImage = $event->image;
        }
        $startDate = $request->get('date'); 
        $endDate = $parts = explode('-', now());
        $years = $parts[0] - $startDate ;

        $event->name =  $request->get('name');
        $event->date = $request->get('date');
        $event->image = $profileImage;
        $event->description = $request->get('description');
        $event->years =  $years;
        $event->update();

        return redirect()->route('events.index')
                        ->with('success','Event updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
     
        return redirect()->route('events.index')
                        ->with('success','Event deleted successfully');
    }
}
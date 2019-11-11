<?php

namespace App\Http\Controllers\Admin;

use App\EventType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Requests\UpdateEventTypeRequest;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $eventTypes = EventType::all();

        return view('admin.event-types.index', compact('eventTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.event-types.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   App\Http\Requests\StoreEventTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventTypeRequest $request)
    {
      $eventType = EventType::create($request->all());

        if ($request->hasFile('photo')) {
            $eventType->addMediaFromRequest('photo')->toMediaCollection('photo');
				}
				
				session()->flash('success', 'Event Type Created Successfully');

        return redirect()->route('admin.event-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function show(EventType $eventType)
    {
      return view('admin.event-types.show', compact('eventType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $eventType)
    {
      return view('admin.event-types.edit', compact('eventType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateEventTypeRequest  $request
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
      $eventType->update($request->all());

        if ($request->hasFile('photo')) {
					
           $eventType->photo->delete();
         
          $eventType->addMediaFromRequest('photo')->toMediaCollection('photo');
				} 

				session()->flash('success', 'Event Type Updated Successfully');

        return redirect()->route('admin.event-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
			$eventType->delete();
			
			session()->flash('success', 'Event Type Deleted Successfully');

      return back();
    }
}
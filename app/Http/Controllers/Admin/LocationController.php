<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $locations = Location::all();

      return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\StoreLocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
      $location = Location::create($request->all());

        if ($request->hasFile('photo')) {
            $location->addMediaFromRequest('photo')->toMediaCollection('photo');
				}
				
				session()->flash('success', 'Location Created Successfully');

        return redirect()->route('admin.locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
      return view('admin.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateLocationRequest   $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest  $request, Location $location)
    {
      $location->update($request->all());

        if ($request->hasFile('photo')) {
					
           $location->photo->delete();
         
          $location->addMediaFromRequest('photo')->toMediaCollection('photo');
				} 

				session()->flash('success', 'Location Updated Successfully');

        return redirect()->route('admin.locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
      
			$location->delete();
			
			session()->flash('success', 'Location Deleted Successfully');

      return back();
    }
}
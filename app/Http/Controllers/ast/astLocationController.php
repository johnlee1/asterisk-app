<?php namespace App\Http\Controllers\ast;

// Copyright 2015 John Lee

// This file is part of The Asterisk App. 

// The Asterisk App is free software: you can redistribute it and/or modify 
// it under the terms of the GNU General Public License as published by 
// the Free Software Foundation, either version 3 of the License, or 
// (at your option) any later version. 

// The Asterisk App is distributed in the hope that it will be useful, 
// but WITHOUT ANY WARRANTY; without even the implied warranty of 
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
// GNU General Public License for more details. 

// You should have received a copy of the GNU General Public License 
// along with The Asterisk App. If not, see <http://www.gnu.org/licenses/>. 

use App\Http\Controllers\Controller;
use App\Models\ast\astPhoneModel;
use App\Models\ast\astPhoneTemplateModel;
use App\Models\ast\astPhoneParameterValueModel;
use App\Models\ast\astParameterModel;
use App\Models\ast\astPhoneLocationModel;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use Session;
use Validator;
use View;
use Mail;
use Carbon\Carbon;
use Stringy\create;
use Parser;

class astLocationController extends Controller {

	
	/**
	 * Display a list of the locations.
	 */
	public function index()
	{
		$query = (new astPhoneLocationModel)->newQuery();
		$astLocations = $query->orderBy('PHONE_LOCATION_NAME')->get();
		
		return View::make('ast.astLocations.index')
			   ->with('astLocations', $astLocations);
	}
	
	
	/**
	 * Show details of a specific location.
	 */
	public function show($id)
	{
		$location = astPhoneLocationModel::findOrFail($id);
	
		return View::make('ast.astLocations.show')
			   ->with('location', $location);
	}
	
	
	/**
	 * Create a new location.
	 */
	public function create()
	{
		return View::make('ast.astLocations.create');
	}
	
	
	/**
	 * Edit an existing location.
	 */
	public function edit($id)
	{
		$astPhoneLocation = astPhoneLocationModel::findOrFail($id);
	
		return View::make('ast.astLocations.edit')
		           ->with('location', $astPhoneLocation);
	}
	
	
	/**
	 * Store a new location.
	 */
	public function store(Request $request)
	{
		$input = $request->all();
	
		$newLocation = astPhoneLocationModel::create($input);
	
		Session::flash('astMessage', 'Location has been added!');
	
		return Redirect::route('locations');
	}
	

	/**
	 * Update an edited location.
	 */
	public function storeEdited($id, Request $request)
	{
		$input = $request->all();
	
		$astPhoneLocation = astPhoneLocationModel::findOrFail($id);
	
		$astPhoneLocation->update($input);
	
		Session::flash('astMessage', 'Location has been updated!');
	
		return Redirect::route('locations');
	}
	
	
	/**
	 * Delete an existing location if no phone uses the model.
	 */
	public function delete($id)
	{
		$astPhonesWithLocation = astPhoneModel::where('PHONE_LOCATION_ID','=',$id)->get();
	
		if (count($astPhonesWithLocation) == 0)
		{
			$astPhoneLocation = astPhoneLocationModel::findOrFail($id);
	
			$astPhoneLocation->delete();
	
			Session::flash('astMessage', 'Location has been deleted!');
	
			return Redirect::route('locations');
		}
	
		else
		{
			Session::flash('astDeleteMessage', 'In order to delete this location, all phones with this location must be deleted first.');
	
			return redirect()->route('showLocation', [$id]);
		}
	}

}

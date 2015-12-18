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
use App\Models\ast\astPhoneModelModel;
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

class astModelController extends Controller {

		
	/**
	 * Display a list of the models.
	 */
	public function index()
	{
		$query = (new astPhoneModelModel)->newQuery();
		$astModels = $query->orderBy('BRAND')->get();
		
		return View::make('ast.astModels.index')
			   ->with('astModels', $astModels);
	}
	
	
	/**
	 * Show details of a specific model.
	 */
	public function show($id)
	{
		$astModel = astPhoneModelModel::findOrFail($id);
	
		return View::make('ast.astModels.showModel')
		           ->with('astModel', $astModel);
	}
	
	
	/**
	 * Create a new model.
	 */
	public function create()
	{
		return View::make('ast.astModels.create');
	}
	
	
	/**
	 * Store a new model.
	 */
	public function store(Request $request)
	{
		$input = $request->all();
			
		astPhoneModelModel::create($input);
			
		Session::flash('astMessage', 'Model has been added!');
	
		return Redirect::route('models');
	}
	
	
	/**
	 * Edit an existing model.
	 */
	public function edit($id)
	{
		$astPhoneModel = astPhoneModelModel::findOrFail($id);
	
		return View::make('ast.astModels.edit')
			   ->with('astPhoneModel', $astPhoneModel);
	}
	
	
	/**
	 * Update an edited model.
	 */
	public function storeEdited($id, Request $request)
	{
		$input = $request->all();
	
		$astPhoneModel = astPhoneModelModel::findOrFail($id);
	
		$astPhoneModel->update($input);
	
		Session::flash('astMessage', 'Model has been updated!');
	
		return Redirect::route('models');
	}
	
	
	/**
	 * Delete an existing model if no phone uses the model.
	 */
	public function delete($id)
	{
		$astPhonesWithModel = astPhoneModel::where('PHONE_MODEL_ID','=',$id)->get();
	
		if (count($astPhonesWithModel) == 0)
		{
			$astPhoneModel = astPhoneModelModel::findOrFail($id);
	
			$astPhoneModel->delete();
				
			Session::flash('astMessage', 'Model has been deleted!');
	
			return Redirect::route('models');
		}
	
		else
		{
			Session::flash('astDeleteMessage', 'In order to delete this model, all phones with this model must be deleted first.');
	
			return redirect()->route('showModel', [$id]);
		}
	}
}

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

class astParameterController extends Controller {

	
	
	/**
	 * Display a list of the parameters.
	 */
	public function index()
	{
		$query = (new astParameterModel)->newQuery();
		$astParameters = $query->orderBy('NAME')->get();
		
		return View::make('ast.astParameters.index')
			   ->with('astParameters', $astParameters);
	}
	
	
	/**
	 * Show details of a specific parameter.
	 */
	public function show($id)
	{
		$parameter = astParameterModel::findOrFail($id);
		
		$templates = astParameterModel::parameterToTemplates($parameter);
	
		return View::make('ast.astParameters.show')
			   ->with('parameter', $parameter)
			   ->with('templates', $templates);
	}

	
	/**
	 * Create a new parameter.
	 */
	public function create()
	{
		return View::make('ast.astParameters.create');
	}
	
	
	/**
	 * Store a new parameter.
	 */
	public function store(Request $request)
	{
		$input = $request->all();
	
		$newParameter = astParameterModel::create($input);
		
		Session::flash('astMessage', 'Parameter has been added!');
	
		return Redirect::route('parameters');
	}

	
	/**
	 * Edit an existing parameter.
	 */
	public function edit($id)
	{
		$astParameter = astParameterModel::findOrFail($id);
	
		return View::make('ast.astParameters.edit')
		 	   ->with('astParameter', $astParameter);
	}

	
	/**
	 * Update an edited parameter.
	 */
	public function storeEdited($id, Request $request)
	{
		$input = $request->all();
	
		$astParameter = astParameterModel::findOrFail($id);
	
		$astParameter->update($input);
	
		Session::flash('astMessage', 'Parameter has been updated!');
	
		return Redirect::route('parameters');
	}

	
	/**
	 * Delete an existing parameter.
	 */
	public function delete($id)
	{
		// delete parameter values 
		$astParameterValues = astPhoneParameterValueModel::where('PARAMETER_ID', '=', $id)->get();
		foreach($astParameterValues as $astParameterValue)
		{
			$astParameterValue->delete();
		}
	
		$astParameter = astParameterModel::findOrFail($id);
	
		$astParameter->delete();
		
		Session::flash('astMessage', 'Parameter has been deleted!');
	
		return Redirect::route('parameters');
	
	}
	
}

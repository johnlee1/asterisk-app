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
//use Request;
use Mail;
use Carbon\Carbon;
use Stringy\create;
use Parser;

class astTemplateController extends Controller {

	
	
	
	/**
	 * Display a list of the templates.
	 */
	public function index()
	{
		$query = (new astPhoneTemplateModel)->newQuery();
		$astTemplates = $query->orderBy('DESCRIPTION')->get();
		
		return View::make('ast.astTemplates.index')
			   ->with('astTemplates', $astTemplates);
	}

	
	/**
	 * Show details of a specific template.
	 */
	public function show($id)
	{
		$astTemplate = astPhoneTemplateModel::findOrFail($id);
	
		return View::make('ast.astTemplates.showTemplate')
			   ->with('astTemplate', $astTemplate);
	}

	
	/**
	 * Create a new template.
	 */
	public function create()
	{
		return View::make('ast.astTemplates.create');
	}
	
	
	/**
	 * Store a new template.
	 */
	public function store(Request $request)
	{
		$input = $request->all();
	
		$newTemplate = astPhoneTemplateModel::create($input);
		
		Session::flash('astMessage', 'Template has been added!');
	
		return Redirect::route('templates');
	}

	
	/**
	 * Edit an existing template.
	 */
	public function edit($id)
	{
		$astPhoneTemplate = astPhoneTemplateModel::findOrFail($id);
	
		return View::make('ast.astTemplates.edit')
			   ->with('astPhoneTemplate', $astPhoneTemplate);
	}

	
	/**
	 * Update an edited template.
	 */
	public function storeEdited($id, Request $request)
	{
		$input = $request->all();
	
		$astPhoneTemplate = astPhoneTemplateModel::findOrFail($id);
	
		$astPhoneTemplate->update($input);
	
		Session::flash('astMessage', 'Template has been updated!');
	
		return Redirect::route('templates');
	}

	
	/**
	 * Delete an existing template if no phone uses the template.
	 */
	public function delete($id)
	{	
		$astPhonesWithTemplate = astPhoneModel::where('PHONE_TEMPLATE_ID','=',$id)->get();
		
		if (count($astPhonesWithTemplate) == 0)
		{		
			$astPhoneTemplate = astPhoneTemplateModel::findOrFail($id);
		
			$astPhoneTemplate->delete();
			
			Session::flash('astMessage', 'Template has been deleted!');
		
			return Redirect::route('templates');
		}
		
		else
		{
			Session::flash('astDeleteMessage', 'In order to delete this template, all phones with this template must be deleted first.');
				
			return redirect()->route('showTemplate', [$id]);
		}
	}
}

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
use App\Models\ast\usersModel;
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
use ZipArchive;
use PharData;
use PhpParser\Node\Stmt\Else_;

class astPhoneController extends Controller {

		
	/**
	 * Display a list of the phones.
	 */
	public function index()
	{
		$query = (new astPhoneModel)->newQuery();
		$astPhones = $query->orderBy('MAC')->get();
		
		return View::make('ast.astPhones.index')
		 	   ->with('astPhones', $astPhones);
	}


	/**
	 * Create a new phone.
	 */
	public function create()
	{
		return View::make('ast.astPhones.create')
			   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList())
		           ->with('astResponseTypes', astPhoneTemplateModel::astArrayForList())
		           ->with('astBrandModelTypes', astPhoneModelModel::astArrayForBrandModelList());
	}

	
	/**
	 * Create new phone parameters for a new phone.
	 */	
	public function createParameters($id, Request $request)
	{
		$input = $request->all();

		$astPhone = astPhoneModel::findOrFail($id);
		
		$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
		
		// an array of parameters based on the template
		$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
		
		foreach ($input as $name => $value) 
		{
			if (in_array($name, $parametersArray))
			{	
				$parameterIds = astParameterModel::where('NAME', '=', $name)->get();
								
				//there should only be one parameterId but used foreach anyways because $parameterIds is an array
				foreach($parameterIds as $parameterId) {	
					$newValue = array(
							"PHONE_ID" => $id,
							"PARAMETER_ID" => $parameterId->PARAMETER_ID,
							"VALUE" => $value,
						);
					$result = astPhoneParameterValueModel::create($newValue);
				}
			}
		}
		
		Session::flash('astMessage', 'Phone has been added!');
				
		return Redirect::route('phones');
	}

	
	/**
	 * Show details of a specific phone.
	 */	
	public function show($id)
	{
		$astPhone = astPhoneModel::findOrFail($id);

		$astPhoneTemplateName = $astPhone->phoneTemplate->TEMPLATE_NAME;
		
		$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
				
		// an array of parameter values based on the phone
		$astPhoneParameters = astPhoneParameterValueModel::astPhoneParameterValuesToArray($astPhone);
		
		// an array of parameters based on the template
		$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
		
		// an array of parameter based on the template
		$fullParametersArray = astPhoneTemplateModel::astXMLFullParametersToArray($astPhoneTemplate);
				
		$astPhoneModel = $astPhone->phoneModel->BRAND.' '.$astPhone->phoneModel->MODEL_NAME;
						
		return View::make('ast.astPhones.showPhone')
		           ->with('astPhone', $astPhone)
		           ->with('astPhoneParameters', $astPhoneParameters)
		           ->with('parametersArray', $parametersArray)
		           ->with('fullParametersArray', $fullParametersArray)
			   ->with('astPhoneTemplateName', $astPhoneTemplateName)
			   ->with('astPhoneModel', $astPhoneModel);
	}


	/**
	 * Edit an existing phone.
	 */	
	public function edit($id)
	{
		
		$astPhone = astPhoneModel::findOrFail($id);
		
		$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
		
		// an array of parameter values based on the phone
		$astPhoneParameters = astPhoneParameterValueModel::astPhoneParameterValuesToArray($astPhone);

		// an array of parameters based on the template
		$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
				
		return View::make('ast.astPhones.editPhone')
			   ->with('astPhone', $astPhone)
			   ->with('astResponseTypes', astPhoneTemplateModel::astArrayForList())
			   ->with('templateNames', astPhoneTemplateModel::templateNamesArrayForList())
			   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList())
			   ->with('astPhoneParameters', $astPhoneParameters)
			   ->with('parametersArray', $parametersArray)
		           ->with('astBrandModelTypes', astPhoneModelModel::astArrayForBrandModelList());
	}	
	
	
	/**
	 * Store a new phone.
	 */	
	public function store(Request $request)
	{
		$validate = $this->doValidate();
		
		if ($validate->passes())
		{
			$input = $request->all();
			
			$newAstPhone = astPhoneModel::create($input);
			
			$astPhoneTemplate = $newAstPhone->phoneTemplate->TEMPLATE;
			
			// an array of parameters based on the template
			$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
			
			// an array of parameter based on the template
			$fullParametersArray = astPhoneTemplateModel::astXMLFullParametersToArray($astPhoneTemplate);
						
			return View::make('ast.astPhones.createParameterValue')
			           ->with('astPhone', $newAstPhone)
	            	   	   ->with('parametersArray', $parametersArray)
				   ->with('fullParametersArray', $fullParametersArray);
		}
		
		else
		{
			Input::flash();
			return Redirect::route('createPhone')
				       ->with('unsuccessfulMessage', 'Unable to add. Mac must be 12 characters.');
		}
	}
	
	
	/**
	 * Update an edited phone.
	 */	
	public function storeEdited($id, Request $request)
	{
		
		$validate = $this->doValidate();
		
		if ($validate->passes())
		{	
			$input = $request->all();
			
			$astPhone = astPhoneModel::findOrFail($id);
					
			$astPhone->update($input);
			
			$astPhoneTemplateDescription = $astPhone->phoneTemplate->DESCRIPTION;
			
			$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
			
			// an array of parameter values based on the phone
			$astPhoneParameters = astPhoneParameterValueModel::astPhoneParameterValuesToArray($astPhone);
			
			// an array of parameter names based on the template
			$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
			
			// an array of parameter based on the template
			$fullParametersArray = astPhoneTemplateModel::astXMLFullParametersToArray($astPhoneTemplate);
					
			Session::flash('astMessage', 'Phone has been updated!');
							
			return View::make('ast.astPhones.editPhoneParameters')
				       ->with('astPhone', $astPhone)
				       ->with('astResponseTypes', astPhoneTemplateModel::astArrayForList())
				       ->with('astPhoneParameters', $astPhoneParameters)
				       ->with('parametersArray', $parametersArray)
				       ->with('fullParametersArray', $fullParametersArray)
				       ->with('astPhoneTemplateDescription', $astPhoneTemplateDescription)
				       ->with('astBrandModelTypes', astPhoneModelModel::astArrayForBrandModelList());
		}
		
		else
		{
			$astPhone = astPhoneModel::findOrFail($id);
				
			Input::flash();
			return redirect()->route('editPhone', [$astPhone->PHONE_ID])
			                 ->with('message', 'Unable to add. Mac must be 12 characters.')
			                 ->withErrors($validate->messages());
		}
	}
	
	
	/**
	 * Updated parameters of a phone.
	 */	
	public function storeEditedParameters($id, Request $request)
	{
		$input = $request->all();
	
		$astPhone = astPhoneModel::findOrFail($id);
		
		$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
	
		// an array of parameters based on the template
		$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
			
		foreach ($input as $name => $value)
		{
			if (in_array($name, $parametersArray))
			{
				$parameterIds = astParameterModel::where('NAME', '=', $name)->get();
	
				// there should only be one parameterId but used array anyways because $parameterIds is an array
				foreach($parameterIds as $parameterId)
				{
					$phoneParameterValueId = astPhoneParameterValueModel::where('PARAMETER_ID', '=', $parameterId->PARAMETER_ID)
																		->where('PHONE_ID', '=', $id)
																		->get();

					// update the value of an existing phoneParameterValue record
					if (count($phoneParameterValueId) > 0)
					{
						$phoneParameterValue = $phoneParameterValueId[0];
						$phoneParameterValue->VALUE = $value;
						$phoneParameterValue->save();
					}
						
					// create a new phoneParameterValue record unless no value was inputted
					else
					{
						if ($value != NULL)
						{
							$newValue = array(
									"PHONE_ID" => $id,
									"PARAMETER_ID" => $parameterId->PARAMETER_ID,
									"VALUE" => $value,
							);
							$test = astPhoneParameterValueModel::create($newValue);
						}
					}
				}
			}
		}
	
		Session::flash('astMessage', 'Phone has been updated!');
	
		return Redirect::route('phones');
	}
	
	
	/**
	 * Copy a phone.
	 */
	public function copy($id)
	{
		$astPhone = astPhoneModel::findOrFail($id);
		
		$astPhoneTemplate = $astPhone->phoneTemplate->TEMPLATE;
		
		// an array of parameter values based on the phone
		$astPhoneParameters = astPhoneParameterValueModel::astPhoneParameterValuesToArray($astPhone);
		
		// an array of parameters based on the template
		$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
		
		return View::make('ast.astPhones.copy')
			   ->with('astPhone', $astPhone)
			   ->with('astResponseTypes', astPhoneTemplateModel::astArrayForList())
			   ->with('templateNames', astPhoneTemplateModel::templateNamesArrayForList())
		 	   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList())
			   ->with('astPhoneParameters', $astPhoneParameters)
			   ->with('parametersArray', $parametersArray)
			   ->with('astBrandModelTypes', astPhoneModelModel::astArrayForBrandModelList());
	}
	
	
	/**
	 * Update a copied phone.
	 */
	public function storeCopied($id, Request $request)
	{
		$mac = $request->MAC;
		$checkForExistingMac = astPhoneModel::where('MAC', '=', $mac)->get();
		
		if (count($checkForExistingMac) == 0)
		{
			$validate = $this->doValidate($id);
		
			if ($validate->passes())
			{
				$input = $request->all();
				
				$oldAstPhone = astPhoneModel::findOrFail($id);
				
				$newAstPhone = astPhoneModel::create($input);
					
				$astPhoneTemplateDescription = $newAstPhone->phoneTemplate->DESCRIPTION;
					
				$astPhoneTemplate = $newAstPhone->phoneTemplate->TEMPLATE;
					
				// an array of parameter values based on the phone
				$astPhoneParameters = astPhoneParameterValueModel::astPhoneParameterValuesToArray($oldAstPhone);
					
				// an array of parameters based on the template
				$parametersArray = astPhoneTemplateModel::astXMLParametersToArray($astPhoneTemplate);
				
				// an array of parameter based on the template
				$fullParametersArray = astPhoneTemplateModel::astXMLFullParametersToArray($astPhoneTemplate);
					
				Session::flash('astMessage', 'Copied phone has been added!');
					
				return View::make('ast.astPhones.editPhoneParameters')
				           ->with('astPhone', $newAstPhone)
			   	           ->with('astResponseTypes', astPhoneTemplateModel::astArrayForList())
				           ->with('astPhoneParameters', $astPhoneParameters)
				           ->with('parametersArray', $parametersArray)
				           ->with('fullParametersArray', $fullParametersArray)
				           ->with('astPhoneTemplateDescription', $astPhoneTemplateDescription)
				           ->with('astBrandModelTypes', astPhoneModelModel::astArrayForBrandModelList());
			}
		
			else
			{
				$astPhone = astPhoneModel::findOrFail($id);
		
				Input::flash();
				return redirect()->route('copyPhone', [$astPhone->PHONE_ID])
				                 ->with('message', 'Unable to add. Mac must be 12 characters.')
				                 ->withErrors($validate->messages());
			}
		}
		
		else 
		{
			$astPhone = astPhoneModel::findOrFail($id);
			
			Input::flash();
			return redirect()->route('copyPhone', [$astPhone->PHONE_ID])
			                 ->with('unsuccessfulMessage', 'Unable to add. Mac must be unique.');
		}
	}
	
	
	/**
	 * Delete an existing phone.
	 */
	public function delete($id)
	{
		astPhoneParameterValueModel::where('PHONE_ID','=',$id)->delete();
		
		$astPhone = astPhoneModel::findOrFail($id);
		
		$astPhone->delete();
		
		Session::flash('astMessage', 'Phone has been deleted!');
		
		return Redirect::route('phones');
		
	}
	

	/**
	 * Show multiple phones for deletion.
	 */
	public function showMultiple()
	{
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.deleteMultiple')
				   ->with('astPhones', $filteredPhones);
		}
		
		else
		{	
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.deleteMultiple')
				   ->with('astPhones', $astPhones);	
		}
	}
	
	
	/**
	 * Show multiple phones for deletion.
	 */
	public function showMany()
	{
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.deleteMany')
				   ->with('astPhones', $filteredPhones);
		}
		
		else
		{	
			$macFilter = session()->get('astMACFilter');
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.deleteMany')
				   ->with('astPhones', $astPhones);	
		}
	}
	

	/**
	 * Delete multiple phones.
	 */
	public function deleteMultiple()
	{		
		$phoneRecords = Input::get('MAC');
		
		// if didn't select any phones to delete
		if (count($phoneRecords) == 0)
		{
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
						
			return View::make('ast.astPhones.deleteMultiple')
				   ->with('astPhones', $astPhones);
		}
		
		// delete phones
		foreach ($phoneRecords as $phoneRecord)
		{
			$astPhone = astPhoneModel::where('MAC', '=', $phoneRecord)->get();
							
			astPhoneParameterValueModel::where('PHONE_ID','=',$astPhone[0]->PHONE_ID)->delete();
						
			$astPhone[0]->delete();
		}
		
		session()->forget('astMACFilter');
		
		$query = (new astPhoneModel)->newQuery();
		$astPhones = $query->orderBy('MAC')->get();
		
		Session::flash('astMessage', 'Phones have been deleted!');
		
		return View::make('ast.astPhones.deleteMultiple')
		           ->with('astPhones', $astPhones);
	}
	
	
	/**
	 * Filter through phones to delete.
	 */
	public function deleteFilter1()
	{
		session(['astMACFilter' => Input::get('MAC')]);
		
		$macFilter = Input::get('MAC');
	
		$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
		return View::make('ast.astPhones.deleteMultiple')
			   ->with('astPhones', $filteredPhones);
	}
	
	
	/**
	 * Filter through phones to delete.
	 */
	public function deleteFilter2()
	{
		session(['astMACFilter' => Input::get('MAC')]);
		
		$macFilter = Input::get('MAC');
	
		$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
		return View::make('ast.astPhones.deleteMany')
			   ->with('astPhones', $filteredPhones);
	}
	
	
	/**
	 * Filter through phones.
	 */	
	public function filter()
	{
		$macFilter = Input::get('MAC');		
		$descriptionFilter = Input::get('DESCRIPTION');

		$allPhones = astPhoneModel::all();
				
		$filteredPhonesByMac = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
		$filteredPhonesByDescription = astPhoneModel::where('DESCRIPTION','LIKE','%'.$descriptionFilter.'%')->orderBy('MAC')->get();
		
		// filter both mac and description
		if (count($filteredPhonesByMac) != count($allPhones) && count($filteredPhonesByDescription) != count($allPhones) && count($filteredPhonesByMac) != 0 && count($filteredPhonesByDescription) != 0)
		{
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->where('DESCRIPTION','LIKE','%'.$descriptionFilter.'%')->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.index')
				   ->with('astPhones', $filteredPhones);
		}
		
		// filter mac
		elseif (count($filteredPhonesByMac) != 0 && count($filteredPhonesByMac) != count($allPhones))
		{
			return View::make('ast.astPhones.index')
			           ->with('astPhones', $filteredPhonesByMac);
		}

		// filter description
		else
		{
			return View::make('ast.astPhones.index')
			           ->with('astPhones', $filteredPhonesByDescription);
		}
	}
	
	
	/**
	 * Filter through phones to download.
	 */
	public function downloadFilter()
	{
		session(['astMACFilter' => Input::get('MAC')]);
	
		$macFilter = Input::get('MAC');
	
		$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
		return View::make('ast.astPhones.download')
		           ->with('astPhones', $filteredPhones);
	}
	
	
	/**
	 * Filter through phones to download for CSV.
	 */
	public function CSVDownloadFilter()
	{
		session(['astMACFilter' => Input::get('MAC')]);
	
		$macFilter = Input::get('MAC');
	
		$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
		return View::make('ast.astPhones.export')
			   ->with('astPhones', $filteredPhones);
	}
	
	
	/**
	 * Filter through phones to download.
	 */
	public function autopushFilter()
	{
		session(['astMACFilter' => Input::get('MAC')]);
		session(['astLocationFilter' => Input::get('LOCATION')]);
		
		$macFilter = Input::get('MAC');
		$locationFilter = Input::get('LOCATION');
		
		$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')
		                               ->where('PHONE_LOCATION_ID', '=', $locationFilter)->orderBy('MAC')->get();
	
		return View::make('ast.astPhones.autopush')
			   ->with('astPhones', $filteredPhones)
			   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
	}
		
	
	/**
	 * Generate an XML file.
	 */
	public function generate($id)
	{
		$astPhone = astPhoneModel::findOrFail($id);
		
		$template = $astPhone->phoneTemplate->TEMPLATE;
				
		$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $id)->get();
				
		// place the parameter values into the template
		foreach ($values as $value)
		{
			$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
		}
		
		$parameters = astParameterModel::all();
		
		// replace unused parameters with a blank space
		foreach ($parameters as $parameter)
		{
			$template = str_replace('_'.$parameter->NAME.'_', '', $template);
		}
						
		return View::make('ast.astPhones.generate')
		           ->with('astPhone', $astPhone)
		           ->with('template', $template)
			   ->with('overwrite', false);
	}

	
	/**
	 * Download the XML file.
	 */
	public function downloadXML($id)
	{
		$astPhone = astPhoneModel::findOrFail($id);
		
		$template = $astPhone->phoneTemplate->TEMPLATE;
		
		$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $id)->get();
		
		// place the parameter values into the template
		foreach ($values as $value)
		{
			$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
		}
		
		$filename = $astPhone->phoneModel->PSN . '-' . $astPhone->MAC . '.cnf.xml';
		$filepath = 'documents/ast_xml/' . $filename;
		$outfile = fopen($filepath, "w");
		fwrite($outfile, $template);
		fclose($outfile);
	
		return Response::download($filepath, $filename, ['Content-Type'=>'text/xml']);
	}
	
	
	/**
	 * Show page to download multiple XML
	 */
	public function showMultipleXML()
	{		
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
				
			return View::make('ast.astPhones.download')
			           ->with('astPhones', $filteredPhones);
		}
	
		else
		{
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
				
			return View::make('ast.astPhones.download')
			           ->with('astPhones', $astPhones);
		}
	}
	
	
	/**
	 * Show page to download multiple XML with checkboxes checked.
	 */
	public function showManyXML()
	{
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
				
			return View::make('ast.astPhones.downloadWithChecked')
				   ->with('astPhones', $filteredPhones);
		}
	
		else
		{
			$macFilter = session()->get('astMACFilter');
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
				
			return View::make('ast.astPhones.downloadWithChecked')
				   ->with('astPhones', $astPhones);
		}
	}
	

	/**
	 * Show page to select multiple phones for CSV download with checkboxes unchecked.
	 */
	public function showMultipleForCSV()
	{
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.export')
				   ->with('astPhones', $filteredPhones);
		}
	
		else
		{
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.export')
				   ->with('astPhones', $astPhones);
		}
	}
	
	
	/**
	 * Show page to select multiple phones for CSV download with checkboxes checked.
	 */
	public function showManyForCSV()
	{
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.exportWithChecked')
				   ->with('astPhones', $filteredPhones);
		}
	
		else
		{
			$macFilter = session()->get('astMACFilter');
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.exportWithChecked')
				   ->with('astPhones', $astPhones);
		}
	}
	
	
	/**
	 * Show page to download multiple XML
	 */
	public function showMultipleForAutopush($id)
	{
		if ($id == true)
		{
			$astPhones = [];
			
			return View::make('ast.astPhones.autopush')
				   ->with('astPhones', $astPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
		
		if (session()->has('astMACFilter'))
		{
			$macFilter = session()->get('astMACFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.autopush')
				   ->with('astPhones', $filteredPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
	
		else
		{
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
				
			return View::make('ast.astPhones.autopush')
				   ->with('astPhones', $astPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
	}
	
	
	/**
	 * Show page to download multiple XML with checkboxes checked.
	 */
	public function showManyForAutopush()
	{
		if (session()->has('astMACFilter') or session()->has('astLocationFilter'))
		{	
			$macFilter = session()->get('astMACFilter');
			$locationFilter = session()->get('astLocationFilter');
			$filteredPhones = astPhoneModel::where('MAC','LIKE','%'.$macFilter.'%')
										   ->where('PHONE_LOCATION_ID', '=', $locationFilter)->orderBy('MAC')->get();
	
			return View::make('ast.astPhones.autopushWithChecked')
				   ->with('astPhones', $filteredPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
	
		else
		{
			$astPhones = [];
	
			return View::make('ast.astPhones.autopushWithChecked')
				   ->with('astPhones', $astPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
	}
	

	/**
	 * Show page to download multiple XML with checkboxes checked.
	 */
	public function autopushMultipleXML()
	{
		// delete current xml files in the folder
		foreach (glob('documents/ast_zip/*') as $fileName)
		{
			unlink(public_path().'/'.$fileName);
		}
		
		$phoneRecord = Input::get('MAC');
		
		// if didn't select any files to download
		if (count($phoneRecord) == 0)
		{
			$astPhones = [];
				
			return View::make('ast.astPhones.autopush')
				   ->with('astPhones', $astPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
		
		foreach ($phoneRecord as $macAddress)
		{
			$astPhone = astPhoneModel::where('MAC', '=', $macAddress)->get();
			$template = $astPhone[0]->phoneTemplate->TEMPLATE;
			$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $astPhone[0]->PHONE_ID)->get();
		
			// place the parameter values into the template
			foreach ($values as $value)
			{
				$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
			}
				
			$filename = $astPhone[0]->phoneModel->PSN . '-' . $astPhone[0]->MAC . '.cnf.xml';
			$filepath = 'documents/ast_zip/' . $filename;
			$outfile = fopen($filepath, "w");
			fwrite($outfile, $template);
			fclose($outfile);
		}
		
		$zip = new ZipArchive();
		$zipFileName = 'xmlFiles.zip';
		
		if ($zip->open(public_path().'/documents/ast_zip/'.$zipFileName, ZipArchive::CREATE ) === true )
		{
			foreach (glob('documents/ast_zip/*') as $fileName)
			{
				if (substr($fileName,-1) != 'p')
				{
					$file = basename( $fileName );
					$zip->addFile($fileName, $file);
				}
			}
		
			$zip->close();
		}
		
				
		// FILE TRANSFER
		
		$astPhone =  $astPhone[0];
		
		$serverIP = $astPhone->phoneLocation->SERVER_IP;
		
		// Remote File Name and Path
		$remote_file = $astPhone->phoneLocation->TFTP_DIRECTORY . $zipFileName;
			
		// FTP Account (Remote Server)
		$ftp_host = $serverIP; // host
		$ftp_user_name = Input::get('serverUsername'); // username
		$ftp_user_pass = Input::get('serverPassword'); // password
		
		// Connect using basic FTP
		$connect_it = ftp_connect($ftp_host);
		
		if ($connect_it == false)
		{
			return redirect()->back();
		}
		
		// Login to FTP
		$login_result = ftp_login($connect_it, $ftp_user_name, $ftp_user_pass);
		
		// If can not connect.
		if ($login_result == false)
		{
			return redirect()->back();
		}
		
		// check if file already exists
		$check_file_exist = $remote_file;
		$contents_on_server = ftp_nlist($connect_it, $astPhone->phoneLocation->TFTP_DIRECTORY);
		if (in_array($check_file_exist, $contents_on_server))
		{
			session(['astServerUsername' => $ftp_user_name, 'astServerPassword' => $ftp_user_pass]);
			
			$astPhones = [];
			
			Session::flash('unsuccessfulMessage', 'Zip file already exists.');
				
			return View::make('ast.astPhones.autopush')
				   ->with('astPhones', $astPhones)
				   ->with('astLocationResponseTypes', astPhoneLocationModel::astArrayForLocationList());
		}
		
		$filepath = public_path().'/documents/ast_zip/'.$zipFileName;
		
		// Send $local_file to FTP
		if (ftp_put($connect_it, $remote_file, $filepath, FTP_BINARY))
		{
			// Close the connection
				
			ftp_close($connect_it);
				
			Session::flash('astMessage', 'Zip file has been transferred!');
		
			return Redirect::route('phones');
		}
		
		else
		{
			Session::flash('unsuccessfulMessage', 'Zip file could not be transferred!');
		
			return Redirect::route('phones');
		}
	}
	

	/**
	 * Download multiple XML files.
	 */
	public function downloadMultipleXML()
	{
		// delete current xml files in the folder
		foreach (glob('documents/ast_zip/*') as $fileName)
		{		            	
			unlink(public_path().'/'.$fileName);
		}		
		
		$phoneRecord = Input::get('MAC');
		
		// if didn't select any files to download
		if (count($phoneRecord) == 0)
		{
			$query = (new astPhoneModel)->newQuery();
			$astPhones = $query->orderBy('MAC')->get();
			
			return View::make('ast.astPhones.download')
				   ->with('astPhones', $astPhones);
		}
		
		foreach ($phoneRecord as $macAddress)
		{
			$astPhone = astPhoneModel::where('MAC', '=', $macAddress)->get();
			$template = $astPhone[0]->phoneTemplate->TEMPLATE;
			$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $astPhone[0]->PHONE_ID)->get();
		
			// place the parameter values into the template
			foreach ($values as $value)
			{
				$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
			}
			
			$filename = $astPhone[0]->phoneModel->PSN . '-' . $astPhone[0]->MAC . '.cnf.xml';
			$filepath = 'documents/ast_zip/' . $filename;
			$outfile = fopen($filepath, "w");
			fwrite($outfile, $template);
			fclose($outfile);
		}
		
		$zip = new ZipArchive();
		$zipFileName = 'xmlFiles.zip';
		
		if ($zip->open(public_path().'/documents/ast_zip/'.$zipFileName, ZipArchive::CREATE ) === true )
		{
			foreach (glob('documents/ast_zip/*') as $fileName)
            {
            	if (substr($fileName,-1) != 'p')
            	{
	            	$file = basename( $fileName );
	            	$zip->addFile($fileName, $file);
            	}
            }
		
			$zip->close();
		}
			
		return Response::download(public_path().'/documents/ast_zip/'.$zipFileName, $zipFileName, ['Content-Type'=>'application/zip']);
	}
	
	
	/**
	 * Download CSV.
	 */
	public function downloadCSV()
	{
		$headers = [
				'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',   	
				'Content-type'        => 'text/csv',
				'Content-Disposition' => 'attachment; filename=exportedPhoneList.csv',  
				'Expires'             => '0',   
				'Pragma'              => 'public'
		];
		
		$list = [];
		$topRow = ['template', 'output', ''];
		$fullParametersArray = astParameterModel::all();
		$parameters = [];
		foreach($fullParametersArray as $parameter)
		{
			if ($parameter->NAME != 'ignorePhoneType' && $parameter->NAME != 'ignoreLocation')
			{
				$modifiedParameter = '_'.$parameter->NAME.'_';
				array_push($parameters, $modifiedParameter);
				array_push($topRow, $modifiedParameter);
			}
			else 
			{
				$modifiedParameter = '_'.$parameter->NAME;
				array_push($parameters, $modifiedParameter);
				array_push($topRow, $modifiedParameter);
			}
		}
		array_push($list, $topRow);
		$macAddresses = Input::get('MAC');
		if (count($macAddresses)>0)
		{
			foreach($macAddresses as $macAddress)
			{
				$phone = astPhoneModel::where('MAC', '=', $macAddress)->get();
				$phone = $phone[0];
				
				$newRow = [$phone->phoneTemplate->TEMPLATE_NAME, $phone->phoneModel->PSN.'-'.$phone->MAC, ''];
				
				foreach($parameters as $parameter)	
				{
					$parameterID = astParameterModel::where('NAME', '=', ltrim($parameter,'_'))
								        ->orWhere('NAME', '=', rtrim(ltrim($parameter,'_'),'_'))->get();
										
					if (count($parameterID)>0)
					{
						$parameterID = $parameterID[0]->PARAMETER_ID; 
						
						$parameterValue = astPhoneParameterValueModel::where('PHONE_ID','=',$phone->PHONE_ID)
										             ->where('PARAMETER_ID', '=', $parameterID)->get();
						
						if (count($parameterValue)>0)
						{
							$parameterValue = $parameterValue[0]->VALUE;
							
							if (strpos($parameterValue, ';') != false)
							{
								$parameterValue = '"'.$parameterValue.'"';
							}
							
							array_push($newRow, $parameterValue);							
						}
						
						else
						{
							array_push($newRow, '');	
						}

					}
					
					else
					{
						array_push($newRow, '');
					}
				};
				
				array_push($list, $newRow);
			}		
			
			$callback = function() use ($list)
			{
				$FH = fopen('php://output', 'w');
				foreach ($list as $row) {
					fputcsv($FH, $row, ',');
				}
				fclose($FH);
			};
			
			return Response::stream($callback, 200, $headers);
		}
		
		else
		{
			return Redirect::route('exportCSV');
		}
	}
	
	
	/**
	 * Show form to import a CSV.
	 */
	public function import()
	{
		return View::make('ast.astPhones.import');
	}
	
	
	/**
	 * Import a CSV
	 */
	public function importPhones()
	{
		if (Input::hasfile('importfile'))
		{
			$inputFile=Input::file('importfile');
			
			ini_set("auto_detect_line_endings", true); // this is required to handle weird line-endings from Mac
			
			$csvfile=fopen($inputFile->getRealPath(), "r");
			
			$importedPhones = [];
			$failedPhones = [];
			$failedParameters = []; 
			$successLineNumbers = [];
			$failedLineNumbers = [];
			$unknownParameters = [];
			$unknownParametersNames = [];
			
			for ($x = 0; $x < 1; $x++)
			{
				$parameters = fgetcsv($csvfile);
				$templateIndex = array_search("template",$parameters);
				$modelIndex = array_search("output",$parameters);
				$locationIndex = array_search("_ignoreLocation",$parameters);
				$firstLastIndex = array_search("_FIRST-LAST_",$parameters);
				$linelabelIndex = array_search("_LINE-LABEL1_",$parameters);
			}
			
			$lineNumber = 2;
			
			while (!feof($csvfile))
			{
				$columns=fgetcsv($csvfile);
								
				// TEMPLATE
				$templateName = $columns[$templateIndex];
				$template = astPhoneTemplateModel::where('TEMPLATE_NAME', '=', $templateName)->get();
								
				// MODEL
				$psn = explode('-', $columns[$modelIndex])[0];
				$model = astPhoneModelModel::where('PSN', '=', $psn)->get();
				
				// LOCATION
				$phoneLocation = astPhoneLocationModel::where('PHONE_LOCATION_NAME', '=', $columns[$locationIndex])->get();
				
				// MAC
				$modelMac = $columns[$modelIndex];
				$temp = strpos($modelMac, '-');
				$mac = substr($modelMac, $temp+1);
				
				// FIRST_LAST
				$firstLast = $columns[$firstLastIndex];
				
				// LINE-LABEL1
				$linelabel = $columns[$linelabelIndex];
				
				// check if a phone with the same MAC address already exists 
				$macCheck = astPhoneModel::where('MAC', '=', $mac)->get();
				
				//does not go through if does not have template, model, location, or if a phone with the same MAC address already exists
				if ((count($template)>0) && (count($model)>0) && (count($phoneLocation)>0) && (count($macCheck)==0))
				{
					// new record for phone
					$newPhoneRecord = [
						"PHONE_TEMPLATE_ID" => $template[0]->PHONE_TEMPLATE_ID,
						"DESCRIPTION" => $firstLast . ' ' . $linelabel,
						"PHONE_MODEL_ID" => $model[0]->PHONE_MODEL_ID,
						"PHONE_LOCATION_ID" => $phoneLocation[0]->PHONE_LOCATION_ID,
						"MAC" => $mac,
					];
					
					$astPhone = astPhoneModel::create($newPhoneRecord);
					
					array_push($importedPhones, $columns[1]);
					$successLineNumbers[$columns[1]] = $lineNumber;					
					
					// keep track of index for $parameters 
					$i = 0;
					
					// new records for parameter values
					foreach ($columns as $column)
					{
						if ($column != '')
						{
							//corect DLST value
							if ($column[0] == '"')
							{
								$column = trim($column, '"');
							}
							
							$parameterName = $parameters[$i];
							
							if ($parameters[$i][0] == '_')
							{
								$parameterName = ltrim($parameterName, '_');
							}
													
							if (substr($parameters[$i],-1) == '_')
							{
								$parameterName = rtrim($parameterName, '_');
							}
													
							$parameter = astParameterModel::where('NAME', '=', $parameterName)->get();
							
							if ((count($parameter)>0))
							{
								$newPhoneParameterValueRecord = [
										"PHONE_ID" => $astPhone->PHONE_ID,
										"PARAMETER_ID" => $parameter[0]->PARAMETER_ID,
										"VALUE" => $column
								];
								
								astPhoneParameterValueModel::create($newPhoneParameterValueRecord);
							}
							
							// handle unknown parameters
							else 
							{
								if ($parameterName != 'template' && $parameterName != 'output')
								{
									$unknownParameter = [
											"name" => $parameterName,
											"PHONE_ID" => $astPhone->PHONE_ID,
											"PARAMETER_ID" => null,
											"VALUE" => $column
									];
									
									array_push($unknownParameters, $unknownParameter);
									
									// for confirmImport view so that same parameter doesn't get repeated to check off that it is needed
									if (!in_array($parameterName, $unknownParametersNames))
									{
										array_push($unknownParametersNames, $parameterName);
									}					
																	
								}
							}
						}
						$i++;
					}
				}
				
				// phones that are not pushed into the database
				else {		
					if ($columns[1] != null)	
					{				
						array_push($failedPhones, $columns[1]);
						$failedLineNumbers[$columns[1]] = $lineNumber;
						
						if (!(count($template)>0)) $failedParameters[$columns[1]] = 'template';
						elseif (!(count($model)>0)) $failedParameters[$columns[1]] = 'model';
						elseif (!(count($phoneLocation)>0)) $failedParameters[$columns[1]] = 'location';
						elseif (!(count($macCheck)==0)) $failedParameters[$columns[1]] = 'mac';
					}
				}
				
				$lineNumber++;
			}
			
			if (count($unknownParameters) != 0)
			{
				session()->put('unknownParameters', $unknownParameters);
				session()->put('unknownParametersNames', $unknownParametersNames);
			}
			
			return View::make('ast.astPhones.confirmImport')
					   ->with('importedPhones', $importedPhones)
					   ->with('successLineNumbers', $successLineNumbers)
		               		   ->with('failedPhones', $failedPhones)
					   ->with('failedParameters', $failedParameters)
					   ->with('failedLineNumbers', $failedLineNumbers)
					   ->with('unknownParameters', $unknownParameters)
					   ->with('unknownParametersNames', $unknownParametersNames);
		}
		
		else
		{
			Session::flash('unsuccessfulMessage', 'Need to select a CSV file!');
			
			return Redirect::route('importCSV');
		}
	}
	

	/**
	 * Add new parameters from CSV.
	 */
	public function newParameters()
	{
		$parameters = Input::get('unknownParameter');
		
		$allParameters = session()->get('unknownParameters');
		
		$allParametersNames = session()->get('unknownParametersNames');
				
		// create parameters
		foreach ($allParametersNames as $allParameter)
		{
			if (in_array($allParameter, $parameters))
			{
				$newParameter = [
						"DESCRIPTION" => $allParameter,
						"NAME" => $allParameter
				];
				astParameterModel::create($newParameter);
			}
		}
		
		// create parameter values
		foreach ($allParameters as $allParameter)
		{
			if (in_array($allParameter['name'], $parameters))
			{
				$parameterId = astParameterModel::where('NAME', '=', $allParameter['name'])->get();
				$parameterId = $parameterId[0]->PARAMETER_ID;
				
				$newParameterValue = [
						"PHONE_ID" => $allParameter['PHONE_ID'],
						"PARAMETER_ID" => $parameterId,
						"VALUE" => $allParameter['VALUE'],
				];
				astPhoneParameterValueModel::create($newParameterValue);
			}
		}

				
		session()->forget('unknownParameters');	
		session()->forget('unknownParametersNames');
		
		$query = (new astPhoneModel)->newQuery();
		$astPhones = $query->orderBy('MAC')->get();
		
		Session::flash('astMessage', 'Parameters added!');
		
		return View::make('ast.astPhones.index')
			   ->with('astPhones', $astPhones);
	}	
	
	
	/**
	 * Show form to import a CSV.
	 */
	public function export()
	{
		$query = (new astPhoneModel)->newQuery();
		$astPhones = $query->orderBy('MAC')->get();
		
		return View::make('ast.astPhones.export')
			   ->with('astPhones', $astPhones);
	}
	
	
	/**
	 * Transfer the XML file.
	 */
	public function transferXML($id)
	{
	// create file
		
		$astPhone = astPhoneModel::findOrFail($id);
	
		$template = $astPhone->phoneTemplate->TEMPLATE;
	
		$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $id)->get();
	
		// place the parameter values into the template
		foreach ($values as $value)
		{
			$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
		}
	
		$filename = $astPhone->phoneModel->PSN . '-' . $astPhone->MAC . '.cnf.xml';
		$filepath = 'documents/ast_xml/' . $filename;
		$outfile = fopen($filepath, "w");
		fwrite($outfile, $template);
		fclose($outfile);
		
		$serverIP = $astPhone->phoneLocation->SERVER_IP;
		
		$useTFTPDir = $astPhone->phoneModel->USE_TFTP_DIR;
		
	// file transfer		
		
		// Remote File Name and Path 
		if ($useTFTPDir)
		{
			$remote_file = $astPhone->phoneLocation->TFTP_DIRECTORY . $filename;
		}	
		if (!$useTFTPDir)
		{
			$remote_file = $astPhone->phoneLocation->NON_TFTP_DIRECTORY . $filename;
		}
			
		// FTP Account (Remote Server) 
		$ftp_host = $serverIP; // host 
		$ftp_user_name = Input::get('serverUsername'); // username 
		$ftp_user_pass = Input::get('serverPassword'); // password 
		
		// Connect using basic FTP 
		$connect_it = ftp_connect($ftp_host);
		
		if ($connect_it == false)
		{
			Session::flash('unsuccessfulMessage', 'Could not connect.');
				
			return redirect()->back();
		
		}
						
		// Login to FTP 
		$login_result = ftp_login($connect_it, $ftp_user_name, $ftp_user_pass);
				
		// If can not connect.
		if ($login_result == false)
		{
			Session::flash('unsuccessfulMessage', 'Could not connect.');
				
			return redirect()->back();
		}
		
		// check if file already exists
		$check_file_exist = $remote_file;
		if ($useTFTPDir)
		{
			$contents_on_server = ftp_nlist($connect_it, $astPhone->phoneLocation->TFTP_DIRECTORY);
		}
		if (!$useTFTPDir)
		{
			$contents_on_server = ftp_nlist($connect_it, $astPhone->phoneLocation->NON_TFTP_DIRECTORY);
					}
		if (in_array($check_file_exist, $contents_on_server))
		{				
			session(['astServerUsername' => $ftp_user_name, 'astServerPassword' => $ftp_user_pass]);
			
			return View::make('ast.astPhones.generate')
				   ->with('astPhone', $astPhone)
				   ->with('template', $template)
				   ->with('overwrite', true);
		}
		
		// Send $local_file to FTP 
		if (ftp_put($connect_it, $remote_file, $filepath, FTP_BINARY)) 
		{
			// Close the connection
			
			ftp_close($connect_it);
			
			Session::flash('astMessage', 'XML file has been transferred!');
		
			return Redirect::route('phones');
		}
		
		else 
		{
			Session::flash('unsuccessfulMessage', 'XML file could not be transferred!');
				
			return Redirect::route('showPhone', [$id]);
		}
		
	}
		
	
	/**
	 * Transfer the XML file with overwrite.
	 */
	public function transferXMLOverwrite($id)
	{
		// create file
	
		$astPhone = astPhoneModel::findOrFail($id);
	
		$template = $astPhone->phoneTemplate->TEMPLATE;
	
		$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $id)->get();
	
		// place the parameter values into the template
		foreach ($values as $value)
		{
			$template = str_replace('_'.$value->parameter->NAME.'_', $value->VALUE, $template);
		}
	
		$filename = $astPhone->phoneModel->PSN . '-' . $astPhone->MAC . '.cnf.xml';
		$filepath = 'documents/ast_xml/' . $filename;
		$outfile = fopen($filepath, "w");
		fwrite($outfile, $template);
		fclose($outfile);
	
		$serverIP = $astPhone->phoneLocation->SERVER_IP;
	
		// file transfer
	
		// Remote File Name and Path
		$remote_file = '/tftpboot/' . $filename;
	
		// FTP Account (Remote Server)
		$ftp_host = $serverIP; // host
		$ftp_user_name = session()->get('astServerUsername'); // username
		$ftp_user_pass = session()->get('astServerPassword'); // password
	
		session()->forget('astServerUsername');
		session()->forget('astServerPassword');
		
		// Connect using basic FTP
		$connect_it = ftp_connect($ftp_host);
		
		if ($connect_it == false)
		{
			Session::flash('unsuccessfulMessage', 'Could not connect.');
				
			return redirect()->back();
		}
	
		// Login to FTP
		$login_result = ftp_login($connect_it, $ftp_user_name, $ftp_user_pass);
	
		// If can not connect.
		if ($login_result == false)
		{
			Session::flash('unsuccessfulMessage', 'Could not connect.');
				
			return redirect()->back();
		}
	
		// check if file already exists
		$check_file_exist = $remote_file;
		$contents_on_server = ftp_nlist($connect_it, '/tftpboot/');
		if (in_array($check_file_exist, $contents_on_server))
		{
			ftp_delete($connect_it, $remote_file);
		}
		
		// Send $local_file to FTP
		if (ftp_put($connect_it, $remote_file, $filepath, FTP_BINARY))
		{
			// Close the connection
				
			ftp_close($connect_it);
				
			Session::flash('astMessage', 'XML file has been transferred!');
		
			return Redirect::route('phones');
		}
		
		else
		{
			Session::flash('unsuccessfulMessage', 'XML file could not be transferred!');
		
			return Redirect::route('showPhone', [$id]);
		}

	}	
	

	/**
	 * Validation.
	 */
	private function doValidate()
	{
		$rules = array(
			'MAC' => 'required|size:12',
			'DESCRIPTION' => 'max:79'
		);
		
		return Validator::make(Input::all(), $rules);
	}
	
}

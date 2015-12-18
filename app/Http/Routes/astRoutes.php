<?php

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


/**
 * Menu
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	// Show menu
	Route::get('index/', array('as'=>'menu', 'uses'=>'ast\astMenuController@index'));
});


/**
 * Users
 */
Route::group(['middleware'=>'adLogin'], function()
{
        // Show users
        Route::get('users/', array('as'=>'users', 'uses'=>'ast\astUserController@users'));

	// Approve users
	Route::post('approveUsers', ['as'=>'approveUsers', 'uses'=>'ast\astUserController@approve']);

	// Disapprove users
	Route::post('disapproveUsers', ['as'=>'disapproveUsers', 'uses'=>'ast\astUserController@disapprove']);
});


/**
 * Phones
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{	
	// Show a list of phones
	Route::get('phones/', array('as'=>'phones', 'uses'=>'ast\astPhoneController@index'));
	
	// Show the details of a phone
	Route::get('show/{id}', array('as'=>'showPhone', 'uses'=>'ast\astPhoneController@show'));
	
	// Show the form to create a new phone
	Route::get('add', array('as'=>'createPhone', 'uses'=>'ast\astPhoneController@create'));
	
	// Delete a phone
	Route::get('delete/{id}', array('as'=>'deletePhone', 'uses'=>'ast\astPhoneController@delete'));
	
	// Generate an XML
	Route::get('generateXML/{id}', array('as'=>'generateXML', 'uses'=>'ast\astPhoneController@generate'));
	
	// Download an XML
	Route::post('downloadXML/{id}', array('as'=>'downloadXML', 'uses'=>'ast\astPhoneController@downloadXML'));
	
	// Show the page to download multiple XML
	Route::get('showMultipleXML/', array('as'=>'showMultipleXML', 'uses'=>'ast\astPhoneController@showMultipleXML'));
	
	// Show multiple phones for download with boxes checked
	Route::get('showManyXML', array('as'=>'showManyXML', 'uses'=>'ast\astPhoneController@showManyXML'));
	
	// Show multiple phones for CSV download with boxes unchecked
	Route::get('showMultipleForCSV/', array('as'=>'showMultipleForCSV', 'uses'=>'ast\astPhoneController@showMultipleForCSV'));
	
	// Show multiple phones for CSV download with boxes checked
	Route::get('showManyForCSV', array('as'=>'showManyForCSV', 'uses'=>'ast\astPhoneController@showManyForCSV'));
	
	// Show the form to edit a phone when validation fails
	Route::get('edit/{id}', array('as'=>'editPhone', 'uses'=>'ast\astPhoneController@edit'));
	
	// Show the form to copy a phone when validation fails
	Route::get('copy/{id}', array('as'=>'copyPhone', 'uses'=>'ast\astPhoneController@copy'));
	
	// Show the form to import a csv
	Route::get('import', array('as'=>'importCSV', 'uses'=>'ast\astPhoneController@import'));
	
	// Show the form to export a csv
	Route::get('export', array('as'=>'exportCSV', 'uses'=>'ast\astPhoneController@export'));
	
	// Show multiple phones for deletion
	Route::get('showMultiplePhones', array('as'=>'showMultiplePhones', 'uses'=>'ast\astPhoneController@showMultiple'));	
	
	// Show multiple phones for deletion with boxes checked
	Route::get('showManyPhones', array('as'=>'showManyPhones', 'uses'=>'ast\astPhoneController@showMany'));
	
	// Show multiple phones for autopush
	Route::get('showMultipleXMLForAutopush/{id}', array('as'=>'showMultipleXMLForAutopush', 'uses'=>'ast\astPhoneController@showMultipleForAutopush'));
	
	// Show multiple phones for autopush with boxes checked
	Route::get('showManyXMLForAutopush', array('as'=>'showManyXMLForAutopush', 'uses'=>'ast\astPhoneController@showManyForAutopush'));

	// Add new parameters from CSV import
	Route::get('newParameters', array('as'=>'newParameters', 'uses'=>'ast\astPhoneController@newParameters'));

	// Import csv
	Route::post('importPhones', array('as'=>'importPhones', 'uses'=>'ast\astPhoneController@importPhones'));
	
	// Store new phone parameters
	Route::post('addParameters/{id}', array('as'=>'createPhoneParameters', 'uses'=>'ast\astPhoneController@createParameters'));
	
	// Show the form to edit a phone
	Route::post('edit/{id}', array('as'=>'editPhone', 'uses'=>'ast\astPhoneController@edit'));
	
	// Show the form to copy a phone
	Route::post('copy/{id}', array('as'=>'copyPhone', 'uses'=>'ast\astPhoneController@copy'));
	
	// Store new phone
	Route::post('phones', array('as'=>'storePhone', 'uses'=>'ast\astPhoneController@store'));
	
	// Set a filter to show only certain phones
	Route::post('filter', array('as'=>'phonesFilter', 'uses'=>'ast\astPhoneController@filter'));
	
	// Set a filter to show only certain phones to download
	Route::post('downloadFilter', array('as'=>'phonesDownloadFilter', 'uses'=>'ast\astPhoneController@downloadFilter'));
	
	// Set a filter to show only certain phones to download for CSV
	Route::post('CSVDownloadFilter', array('as'=>'CSVDownloadFilter', 'uses'=>'ast\astPhoneController@CSVdownloadFilter'));
	
	// Set a filter to show only certain phones to autopush
	Route::post('autopushFilter', array('as'=>'autopushFilter', 'uses'=>'ast\astPhoneController@autopushFilter'));
	
	// Set a filter to show only certain phones to autopush
	Route::post('autopushMultipleXML', array('as'=>'autopushMultipleXML', 'uses'=>'ast\astPhoneController@autopushMultipleXMl'));
	
	// Set a filter to show only certain phones to delete
	Route::post('deleteFilter1', array('as'=>'phonesDeleteFilter1', 'uses'=>'ast\astPhoneController@deleteFilter1'));
	
	// Set a filter to show only certain phones to delete
	Route::post('deleteFilter2', array('as'=>'phonesDeleteFilter2', 'uses'=>'ast\astPhoneController@deleteFilter2'));
	
	// Download multiple XML files
	Route::post('downloadMultipleXML', array('as'=>'downloadMultipleXML', 'uses'=>'ast\astPhoneController@downloadMultipleXML'));
	
	// Download CSV
	Route::post('downloadCSV', array('as'=>'downloadCSV', 'uses'=>'ast\astPhoneController@downloadCSV'));
	
	// Delete multiple phones
	Route::post('deleteMultiplePhones', array('as'=>'deleteMultiplePhones', 'uses'=>'ast\astPhoneController@deleteMultiple'));
	
	// Transfer XML file
	Route::post('transferXML/{id}', array('as'=>'transferXML', 'uses'=>'ast\astPhoneController@transferXML'));
	
	// Transfer XML file
	Route::post('transferXMLOverwrite/{id}', array('as'=>'transferXMLOverwrite', 'uses'=>'ast\astPhoneController@transferXMLOverwrite'));
	
	// Store edited phone
	Route::patch('storeEdit/{id}', array('as'=>'storeEditedPhone', 'uses'=>'ast\astPhoneController@storeEdited'));
	
	// Store edited phone parameters
	Route::patch('storeEditedParameters/{id}', array('as'=>'storeEditedPhoneParameters', 'uses'=>'ast\astPhoneController@storeEditedParameters'));
	
	// Store copied phone
	Route::patch('storeCopy/{id}', array('as'=>'storeCopiedPhone', 'uses'=>'ast\astPhoneController@storeCopied'));
	
	// Store copied phone parameters
	Route::patch('storeCopyParameters/{id}', array('as'=>'storeCopiedPhoneParameters', 'uses'=>'ast\astPhoneController@storeCopiedParameters'));
	
});



/**
 * Templates
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	// Show a list of templates
	Route::get('templates', array('as'=>'templates', 'uses'=>'ast\astTemplateController@index'));
	
	// Show the details of a template
	Route::get('showTemplate/{id}', array('as'=>'showTemplate', 'uses'=>'ast\astTemplateController@show'));
	
	// Show the form to create a new template
	Route::get('addTemplate', array('as'=>'createTemplate', 'uses'=>'ast\astTemplateController@create'));

	// Delete a template
	Route::get('deleteTemplate/{id}', array('as'=>'deleteTemplate', 'uses'=>'ast\astTemplateController@delete'));
	
	// Show the form to edit a template
	Route::post('editTemplate/{id}', array('as'=>'editTemplate', 'uses'=>'ast\astTemplateController@edit'));
	
	// Store new template
	Route::post('templates', array('as'=>'storeTemplate', 'uses'=>'ast\astTemplateController@store'));
	
	// Store edited template
	Route::patch('storeTemplateEdit/{id}', array('as'=>'storeEditedTemplate', 'uses'=>'ast\astTemplateController@storeEdited'));

});



/**
 * Parameters
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	// Show a list of parameters
	Route::get('parameters', array('as'=>'parameters', 'uses'=>'ast\astParameterController@index'));
	
	// Show the details of a parameter
	Route::get('showParameter/{id}', array('as'=>'showParameter', 'uses'=>'ast\astParameterController@show'));
	
	// Show the form to create a new parameter
	Route::get('addParameter', array('as'=>'createParameter', 'uses'=>'ast\astParameterController@create'));
	
	// Delete a parameter
	Route::get('deleteParameter/{id}', array('as'=>'deleteParameter', 'uses'=>'ast\astParameterController@delete'));
	
	// Show the form to edit a parameter
	Route::post('editParameter/{id}', array('as'=>'editParameter', 'uses'=>'ast\astParameterController@edit'));
	
	// Store the new parameter 
	Route::post('parameters', array('as'=>'storeParameter', 'uses'=>'ast\astParameterController@store'));
	
	// Store edited parameter
	Route::patch('storeParameterEdit/{id}', array('as'=>'storeEditedParameter', 'uses'=>'ast\astParameterController@storeEdited'));

});



/**
 * Models
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	// Show a list of models
	Route::get('models', array('as'=>'models', 'uses'=>'ast\astModelController@index'));

	// Show the details of a parameter
	Route::get('showModel/{id}', array('as'=>'showModel', 'uses'=>'ast\astModelController@show'));

	// Show the form to create a new model
	Route::get('addModel', array('as'=>'createModel', 'uses'=>'ast\astModelController@create'));

	// Delete a parameter
	Route::get('deleteModel/{id}', array('as'=>'deleteModel', 'uses'=>'ast\astModelController@delete'));

	// Show the form to edit a parameter
	Route::post('editModel/{id}', array('as'=>'editModel', 'uses'=>'ast\astModelController@edit'));

	// Store the new parameter
	Route::post('models', array('as'=>'storeModel', 'uses'=>'ast\astModelController@store'));

	// Store edited model
	Route::patch('storeModelEdit/{id}', array('as'=>'storeEditedModel', 'uses'=>'ast\astModelController@storeEdited'));

});


/**
 * Locations
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	// Show a list of locations
	Route::get('locations', array('as'=>'locations', 'uses'=>'ast\astLocationController@index'));

	// Show the details of a location
	Route::get('showLocation/{id}', array('as'=>'showLocation', 'uses'=>'ast\astLocationController@show'));

	// Show the form to create a new location
	Route::get('addLocation', array('as'=>'createLocation', 'uses'=>'ast\astLocationController@create'));

	// Delete a location
	Route::get('deleteLocation/{id}', array('as'=>'deleteLocation', 'uses'=>'ast\astLocationController@delete'));

	// Show the form to edit a location
	Route::post('editLocation/{id}', array('as'=>'editLocation', 'uses'=>'ast\astLocationController@edit'));

	// Store the new location
	Route::post('locations', array('as'=>'storeLocation', 'uses'=>'ast\astLocationController@store'));

	// Store edited location
	Route::patch('storeLocationEdit/{id}', array('as'=>'storeEditedLocation', 'uses'=>'ast\astLocationController@storeEdited'));

});


/**
 * About
 */
Route::group(['middleware'=>'adLogin', 'prefix' => 'asteriskPhone'], function()
{
	Route::get('about/', array('as'=>'about', 'uses'=>'ast\astAboutController@index'));
});

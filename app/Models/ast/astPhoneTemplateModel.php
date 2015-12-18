<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use App\Models\dwh\dwhADUserModel;
use DateTime;
use Session;
use App\Http\Controllers\elt\eltMonthlyBalanceController;
use App\Http\Controllers\elt\eltLeaveTypeController;
use Log;
use DB;


class astPhoneTemplateModel extends Model {
	
	protected $connection = 'mysql';
	protected $table = 'PHONE_TEMPLATE';
	protected $primaryKey = 'PHONE_TEMPLATE_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'PHONE_TEMPLATE_ID',
			'DESCRIPTION',
			'TEMPLATE',
			'TEMPLATE_NAME'
	];
	
	
	/**
	 * Returns an array of template descriptions
	 */
	public static function astArrayForList()
	{
		$astResponseTypes = astPhoneTemplateModel::all();
		
		if (count($astResponseTypes) != 0)
		{
			foreach ($astResponseTypes as $astResponseType) 
			{
				$astArrayForList[$astResponseType->PHONE_TEMPLATE_ID] = $astResponseType->DESCRIPTION;
			}
		
			return $astArrayForList;
		}

		else {
			$emptyArray = [];
			return $emptyArray;
		}
	}
	
	/**
	 * Returns an array of template names
	 */
	public static function templateNamesArrayForList()
	{
		$astResponseTypes = astPhoneTemplateModel::all();
	
		foreach ($astResponseTypes as $astResponseType)
		{
			$astArrayForList[$astResponseType->PHONE_TEMPLATE_ID] = $astResponseType->TEMPLATE_NAME;
		}
	
		return $astArrayForList;
	}
	
	
	/**
	 * Returns an array of parameter names based on a template
	 */
	public static function astXMLParametersToArray($template)
	{
		
		// gather all parameters from PARAMETER db
		
		$allParametersArray = array();
		
		$parameters = astParameterModel::all();
		
		foreach ($parameters as $parameter)
		{
			array_push($allParametersArray, $parameter->NAME);
		}
		
		
		// create array of parameters in XML file
		
		$phoneParametersArray = array();
		
		foreach ($allParametersArray as $parameter) {
			
			$needle = '_'.$parameter.'_';
			
			if (!(strpos($template, $needle) === FALSE)) 
			{
				array_push($phoneParametersArray, $parameter);
			}
		}
		
		return $phoneParametersArray;
	}
	
	
	/**
	 * Returns an array of parameters based on a template
	 */
	public static function astXMLFullParametersToArray($template)
	{
	
		// gather all parameters from PARAMETER db
	
		$allParametersArray = array();
	
		$parameters = astParameterModel::all();
	
		foreach ($parameters as $parameter)
		{
			array_push($allParametersArray, $parameter);
		}
		
		// create array of parameters in XML file
	
		$phoneParametersArray = array();
	
		foreach ($allParametersArray as $parameter) {
				
			$needle = '_'.$parameter->NAME.'_';
				
			if (!(strpos($template, $needle) === FALSE))
			{
				array_push($phoneParametersArray, $parameter);
			}
		}
	
		return $phoneParametersArray;
	}
	
}

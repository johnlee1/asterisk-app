<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use App\Models\dwh\dwhADUserModel;
use App\Models\ast\astPhoneTemplateModel;
use DateTime;
use Session;
use App\Http\Controllers\elt\eltMonthlyBalanceController;
use App\Http\Controllers\elt\eltLeaveTypeController;
use Log;
use DB;


class astParameterModel extends Model {
	
	
	protected $connection = 'mysql';
	protected $table = 'PARAMETER';
	protected $primaryKey = 'PARAMETER_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'PARAMETER_ID',
			'DESCRIPTION',
			'NAME'
	];
	
	
	/**
	 * Returns an array of templates with the parameter.
	 */
	public static function parameterToTemplates($parameter)
	{
		$templatesWithParameter = [];
		
		$templates = astPhoneTemplateModel::all();
		
		foreach ($templates as $template)
		{
			$parameters = astPhoneTemplateModel::astXMLFullParametersToArray($template);
			
			if (in_array($parameter, $parameters))
			{
				array_push($templatesWithParameter, $template->TEMPLATE_NAME);
			}
		}
		
		return $templatesWithParameter;
	}
	
}

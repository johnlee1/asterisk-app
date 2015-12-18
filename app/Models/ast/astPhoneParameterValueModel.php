<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use App\Models\dwh\dwhADUserModel;
use DateTime;
use Session;
use Log;
use DB;


class astPhoneParameterValueModel extends Model {
	
	
	protected $connection = 'mysql';
	protected $table = 'PHONE_PARAMETER_VALUE';
	protected $primaryKey = 'PHONE_PARAMETER_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'PHONE_PARAMETER_ID',
			'PHONE_ID',
			'PARAMETER_ID',
			'VALUE'
	];
	
	
	//Links to other tables
	
	public function parameter()
	{
		return $this->belongsTo('App\Models\ast\astParameterModel', 'PARAMETER_ID', 'PARAMETER_ID');
	}
	
	
	/**
	 * Returns an array of parameter values of a phone
	 */
	public static function astPhoneParameterValuesToArray($astPhone)
	{
		
		$valuesArray = array();
			
		$values = astPhoneParameterValueModel::where('PHONE_ID', '=', $astPhone->PHONE_ID)->get();
					
		foreach ($values as $value)
		{
			$valuesArray[$value->parameter->NAME] = $value->VALUE;
		}
	
		return $valuesArray;
	}
	
	
}

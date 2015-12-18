<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use App\Models\dwh\dwhADUserModel;
use DateTime;
use Session;
use App\Http\Controllers\elt\eltMonthlyBalanceController;
use App\Http\Controllers\elt\eltLeaveTypeController;
use Log;
use DB;


class astPhoneModelModel extends Model {
	
	protected $connection = 'mysql';
	protected $table = 'PHONE_MODEL';
	protected $primaryKey = 'PHONE_MODEL_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'MODEL_NAME',
			'PSN',
			'BRAND',
			'USE_TFTP_DIR',
	];	
	
	/**
	 * Returns an array of Brand/Model combinations
	 */
	public static function astArrayForBrandModelList()
	{
		$astResponseTypes = astPhoneModelModel::all();
	
		if (count($astResponseTypes) != 0) 
		{	
			foreach ($astResponseTypes as $astResponseType) 
			{
				$astArrayForList[$astResponseType->PHONE_MODEL_ID] = $astResponseType->BRAND.' '.$astResponseType->MODEL_NAME;
			}
		
			return $astArrayForList;
		}
		
		else 
		{
			$emptyArray = [];
			return $emptyArray;
		}
	}
	
}

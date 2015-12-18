<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use App\Models\dwh\dwhADUserModel;
use DateTime;
use Session;
use App\Http\Controllers\elt\eltMonthlyBalanceController;
use App\Http\Controllers\elt\eltLeaveTypeController;
use Log;
use DB;


class astPhoneLocationModel extends Model {
	
	protected $connection = 'mysql';
	protected $table = 'PHONE_LOCATION';
	protected $primaryKey = 'PHONE_LOCATION_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'PHONE_LOCATION_NAME',
			'SERVER_IP',
			'TFTP_DIRECTORY',
			'NON_TFTP_DIRECTORY'
	];

	
	/**
	 * Returns an array of location names
	 */
	public static function astArrayForLocationList()
	{
		$astLocationResponseTypes = astPhoneLocationModel::all();
		$astArrayForLocationList = [];
	
		foreach ($astLocationResponseTypes as $astLocationResponseType) 
		{
			$astArrayForLocationList[$astLocationResponseType->PHONE_LOCATION_ID] = $astLocationResponseType->PHONE_LOCATION_NAME;
		}
	
		return $astArrayForLocationList;
	}
	
}

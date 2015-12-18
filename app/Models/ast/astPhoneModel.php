<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Session;
use Log;
use DB;


class astPhoneModel extends Model {
	
	protected $connection = 'mysql';
	protected $table = 'PHONE';
	protected $primaryKey = 'PHONE_ID';
	public $timestamps = false;
	
	protected $fillable = [
			'PHONE_TEMPLATE_ID',
			'DESCRIPTION',
			'PHONE_MODEL_ID',
			'PHONE_LOCATION_ID',
			'MAC'
	];
	
	
	// Authentication. This function is artifact and probably does nothing. 
	
	public static function isAuthUser($currentUser)
	{
		if (in_array($currentUser, $users))
		{
			return true;
		}
		
		else
		{
			return false;
		}
	}
	
	
    // Links to other tables
	
	public function phoneTemplate()
	{
		return $this->belongsTo('App\Models\ast\astPhoneTemplateModel', 'PHONE_TEMPLATE_ID', 'PHONE_TEMPLATE_ID');
	}

	
	public function phoneModel()
	{
		return $this->belongsTo('App\Models\ast\astPhoneModelModel', 'PHONE_MODEL_ID', 'PHONE_MODEL_ID');
	}
	
	
	public function phoneLocation()
	{
		return $this->belongsTo('App\Models\ast\astPhoneLocationModel', 'PHONE_LOCATION_ID', 'PHONE_LOCATION_ID');
	}
	
	
	public function phoneParameterValues()
	{
		return $this->hasMany('App\Models\ast\astPhoneParameterValueModel', 'PHONE_ID', 'PHONE_ID');
	}

	
}

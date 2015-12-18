<?php namespace App\Models\ast;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Session;
use Log;
use DB;


class usersModel extends Model {

        protected $connection = 'mysql';
        protected $table = 'users';
        protected $primaryKey = 'id';
        public $timestamps = false;

        protected $fillable = [
                        'email',
			'password',
			'admin',
			'access'
        ];
}

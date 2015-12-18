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
use Auth;

class astUserController extends Controller {
	
	
	/**
	 * Display a list of the users.
	 */
	public function users()
	{
		$approvedUsers = usersModel::where('access', '=' , '1')->get();
		$unapprovedUsers = usersModel::where('access', '=', '0')->get();
	
		return View::make('ast.administrator')
			   ->with('approvedUsers', $approvedUsers)
			   ->with('unapprovedUsers', $unapprovedUsers);
	}
	
	
	/**
	 * Approve Users
	 */
	public function approve()
	{
		$userIds = Input::get('email');
		
		foreach ($userIds as $userId)
		{
			// give the user access
			$user = usersModel::where('id', '=', $userId)->get();
			$user = $user[0];
			$user->access = '1';
			$user->save();
			
			// send email to user
        		$admin = Auth::user();
			$data = [];
        	        Mail::queue('ast.emailConfirmation', $data, function($message) use($admin, $user) 
                	{
                        	$message->from($admin->email, ' ')->to($user->email, ' ')->subject('You have been approved to use The Asterisk App.');
	                });

		}
		
		$approvedUsers = usersModel::where('access', '=' , '1')->get();
		$unapprovedUsers = usersModel::where('access', '=', '0')->get();
	
		return View::make('ast.administrator')
			   ->with('approvedUsers', $approvedUsers)
		 	   ->with('unapprovedUsers', $unapprovedUsers);
	}

	
	/**
	 * Disapprove Users
	 */
	public function disapprove()
	{
		$userIds = Input::get('email');
	
		foreach ($userIds as $userId)
		{
			$user = usersModel::where('id', '=', $userId)->get();
			$user = $user[0];
			$user->access = '0';
			$user->save();
		}
	
		$approvedUsers = usersModel::where('access', '=' , '1')->get();
		$unapprovedUsers = usersModel::where('access', '=', '0')->get();
	
		return View::make('ast.administrator')
			   ->with('approvedUsers', $approvedUsers)
			   ->with('unapprovedUsers', $unapprovedUsers);
	}
	

}

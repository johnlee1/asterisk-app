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
use App\Models\dwh\dwhADUserModel;
use Input;
use Redirect;
use Response;
use Session;
use Validator;
use View;
use Request;
use Mail;
use Carbon\Carbon;
use App\Models\dwh\dwhNavDepartmentModel;
use Illuminate\Support\Facades\Auth;

class astMenuController extends Controller {
	
	
	/**
	 * Display the menu page.
	 */
	public function index()
	{
		return view('ast.astMenu.astMenu');
	}

	
	public function noAccess()
	{
		Auth::logout();

		return view('auth.noAccess');
	}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TestFileGuardController extends Controller
{
	public function index()
	{
		return response()->json('Login as ' . Auth::user()->username);
	}
}

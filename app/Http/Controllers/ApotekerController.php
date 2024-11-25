<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use Illuminate\Http\Request;

class ApotekerController extends Controller
{
  public function index()
  {
    return view('content.apoteker.index', [
      'Apoteker' => Apoteker::get(),
    ]);
  }
}

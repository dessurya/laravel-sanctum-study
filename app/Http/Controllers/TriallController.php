<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicRollModel;

class TriallController extends Controller
{
    public function index()
    {
        return PublicRollModel::get();
    }
}

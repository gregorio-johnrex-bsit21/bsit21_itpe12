<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
public function students() { return view('admin.students'); }
public function supervisors() { return view('admin.supervisors'); }
public function reports() { return view('admin.reports'); }
public function forms() { return view('admin.forms'); }
public function icons() { return view('admin.icons'); }
public function buttons() { return view('admin.buttons'); }
public function dropdowns() { return view('admin.dropdowns'); }
public function typography() { return view('admin.typography'); }
}
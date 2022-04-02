<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Http\Request;
use Excel;

class ExcelController extends Controller
{
    public function exportTheUser(Request $request)
    {
        return Excel::download(new UserExport($request->id, $request->from, $request->to), 'Personel.xlsx');
    }
}

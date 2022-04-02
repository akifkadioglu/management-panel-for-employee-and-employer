<?php

namespace App\Http\Controllers;

use App\Models\Other;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MobileController extends Controller
{
    public function getUserList()
    {
        return User::orderBy('name')->get();
    }
    public function getWorkList()
    {
        return Work::whereDate('created_at', Carbon::today())->with('user')->orderByDesc('start')->get();
    }
    public function createWork(Request $request)
    {

        $work = new Work();
        $work->user_id = $request->user_id;
        $work->start = $request->start;
        $work->price = Other::first()->price;
        $work->finish = $request->finish;
        $work->save();
        return response([
            'message' => 'başarıyla oluşturuldu'
        ]);
    }
    public function deleteWork(Request $request)
    {
        Work::where('id', $request->id)->first()->delete();
    }
    public function message()
    {
        return Other::first()->message;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Other;
use App\Models\User;
use App\Models\Work;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();
        return $user;
    }
    public function users()
    {
        return User::orderBy('name')->get();
    }
    public function getUser(Request $request)
    {
        $user =  User::where('id', $request->id)->first();
        $work = Work::where('user_id', $user->id)->get();
        if (sizeof($work) == 0) {
            $work = [0];
        }
        return response([
            'user' => $user,
            'work' => $work
        ]);
    }
    public function getWeekWorks(Request $request)
    {
        $from = date('Y-m-d h:m:s', strtotime('-7 days'));
        $to = date(now());
        $works = Work::where('user_id', $request->id)->orderByDesc('created_at')->whereBetween('created_at', [$from, $to])->get();
        $minute = [];
        $time = date_create("2000-1-0");
        foreach ($works as $work) {
            $start_date = date_create($work->start);
            $finish_date = date_create($work->finish);
            $difference = date_diff($start_date, $finish_date);
            $temp = $difference->i + $difference->h * 60;
            if ($work->created_at->format('d') != $time->format('d')) {
                $minute[$work->created_at->format('d')] = $temp;
            } else {
                $minute[$work->created_at->format('d')] += $temp;
            }
            $time = $work->created_at;
        }
        return $minute;
    }
    public function getAllWorks(Request $request)
    {
        $works = Work::where('user_id', $request->id)->orderByDesc('created_at')->get();
        $minute = 0;
        foreach ($works as $work) {
            $start_date = date_create($work->start);
            $finish_date = date_create($work->finish);
            $difference = date_diff($start_date, $finish_date);
            $minute += $difference->i + $difference->h * 60;
        }
        return $minute;
    }
    public function getWeekWorksForPrice(Request $request)
    {
        $from = date('Y-m-d h:m:s', strtotime('-7 days'));
        $to = date(now());
        $works = Work::select(['price'])->where('user_id', $request->id)->orderByDesc('created_at')->whereBetween('created_at', [$from, $to])->get();
        $price = 0;
        foreach ($works as $work) {
            $price += $work->price;
        }
        return $price;
    }
    public function getAllWorksForPrice(Request $request)
    {
        $works = Work::select(['price'])->where('user_id', $request->id)->orderByDesc('created_at')->get();
        $price = 0;
        foreach ($works as $work) {
            $price += $work->price;
        }
        return $price;
    }
    public function changeName(Request $request)
    {
        $request->validate([
            'name' => 'required | unique:users'
        ]);
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();
        return $user->name;
    }
    public function editedWork(Request $request)
    {
        $work = Work::where('id', $request->id)->first();
        $work->start = $request->start;
        $work->finish = $request->finish;
        $work->created_at = $request->date;
        $work->save();
        return $work;
    }
    public function getDaysValues(Request $request)
    {
        $works = Work::where('user_id', $request->id)->orderByDesc('created_at')->whereBetween('created_at', [$request->startDate, $request->finishDate])->get();
        $minute = 0;
        foreach ($works as $work) {
            $start_date = date_create($work->start);
            $finish_date = date_create($work->finish);
            $difference = date_diff($start_date, $finish_date);
            $minute += $difference->i + $difference->h * 60;
        }
        return response([
            'works' => $works,
            'minute' => $minute
        ]);
    }
    public function getWeekAllWorks()
    {
        $from = date('Y-m-d h:m:s', strtotime('-7 days'));
        $to = date(now());
        $works = Work::orderByDesc('user_id')->with('user')->whereBetween('created_at', [$from, $to])->get();
        $minute = [];
        $user = 0;
        foreach ($works as $work) {
            $start_date = date_create($work->start);
            $finish_date = date_create($work->finish);
            $difference = date_diff($start_date, $finish_date);
            $temp = $difference->i + $difference->h * 60;
            if ($work->user->id != $user) {
                $minute[$work->user->name] = $temp;
            } else {
                $minute[$work->user->name] += $temp;
            }
            $user = $work->user->id;
        }
        return $minute;
    }
    public function sendNote(Request $request)
    {
        $note = new Note();
        $note->text = $request->note;
        $note->save();
        return $note;
    }
    public function getNotes()
    {
        return Note::orderByDesc('created_at')->get();
    }
    public function sendMessage(Request $request)
    {
        $message = Other::first();
        $message->message = $request->message;
        $message->save();
        return $message;
    }
    public function getMessage()
    {
        return Other::first()->message;
    }
    public function deleteNote(Request $request)
    {
        Note::where('id', $request->id)->first()->delete();
    }
    public function deleteMessage()
    {
        $message = Other::first();
        $message->message = null;
        $message->save();

    }

    public function getDaysAllValues(Request $request)
    {
        $works = Work::orderByDesc('created_at')->with('user')->whereBetween('created_at', [$request->startDate, $request->finishDate])->get();
        $minute = 0;
        foreach ($works as $work) {
            $start_date = date_create($work->start);
            $finish_date = date_create($work->finish);
            $difference = date_diff($start_date, $finish_date);
            $minute += $difference->i + $difference->h * 60;
        }
        return response([
            'works' => $works,
            'minute' => $minute
        ]);
    }
    public function getDaysAllValuesForPrice(Request $request)
    {
        $works = Work::orderByDesc('created_at')->with('user')->whereBetween('created_at', [$request->startDate, $request->finishDate])->get();
        $price = 0;
        foreach ($works as $work) {
            $price += $work->price;
        }
        return $price;
    }
    public function changePrice(Request $request)
    {
        $price = Other::first();
        $price->price += $request->value;
        $price->save();
    }
    public function getPrice()
    {
        return Other::first()->price;
    }
    public function getWeekAllWorksForPrice()
    {
        $works = Work::select(['price'])->orderByDesc('created_at')->get();
        $price = 0;
        foreach ($works as $work) {
            $price += $work->price;
        }
        return $price;
    }
}

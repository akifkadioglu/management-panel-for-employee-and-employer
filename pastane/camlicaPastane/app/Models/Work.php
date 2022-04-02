<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $guard = [];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public static function theUserWorks()
    {
        $records = Work::query()->with(['user' => function ($query) {
            $query->select('id','name', 'gender', 'phone');
        }])
            ->get()->toArray();
        return $records;
    }
}

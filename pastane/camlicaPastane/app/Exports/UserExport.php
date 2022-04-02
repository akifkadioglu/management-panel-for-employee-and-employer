<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpParser\Node\Expr\Cast\Object_;

class UserExport implements FromCollection, WithHeadings
{
    protected $id;
    protected $from;
    protected $to;

    function __construct($id = 0, $from = false, $to = false)
    {
        $this->id = $id;
        $this->from = Carbon::now()->subDays(7);
        $this->to = Carbon::now();
        if ($from != false & $to != false) {
            $this->from = Carbon::createFromFormat('Y-m-d H:i:s', $from);
            $this->to = Carbon::createFromFormat('Y-m-d H:i:s', $to);
        }
    }

    public function headings(): array
    {
        return [
            'Kullanıcı Id',
            'İsim',
            'Cinsiyet',
            'Telefon',
            'Tarih',
            'Giriş Saati',
            'Çıkış Saati',
            'Saatlik Ücret',
            'Ödenecek Tutar',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $denemeler = Work::theUserWorks();
        $worksWithUsers = [];
        $object = "";

        foreach ($denemeler as $deneme) {
            $object = (object) $deneme;
            $object3 = (object) $object->user;
            $created_at = Carbon::createFromDate($object->created_at);
            if ($this->id != 0) {
                if ($object3->id == $this->id & $created_at < $this->to & $created_at > $this->from) {
                    $start_date = date_create($object->start);
                    $finish_date = date_create($object->finish);
                    $difference = date_diff($start_date, $finish_date);

                    array_push($worksWithUsers, [
                        $object3->id, $object3->name, $object3->gender, $object3->phone,
                        date("Y m d", strtotime($object->created_at)), $object->start, $object->finish, $object->price, number_format((($difference->i + $difference->h * 60) / 60) * $object->price, 2, '.', '')
                    ]);
                }
            } else {
                if ($created_at < $this->to & $created_at > $this->from) {
                    $start_date = date_create($object->start);
                    $finish_date = date_create($object->finish);
                    $difference = date_diff($start_date, $finish_date);

                    array_push($worksWithUsers, [
                        $object3->id, $object3->name, $object3->gender, $object3->phone,
                        date("Y m d", strtotime($object->created_at)), $object->start, $object->finish, $object->price, number_format((($difference->i + $difference->h * 60) / 60) * $object->price, 2, '.', '')
                    ]);
                }
            }
        }
        return collect([$worksWithUsers]);
    }
}

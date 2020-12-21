<?php

namespace App\Imports;

use App\Feedback;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FeedbackImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \App\Models\Feedback|null
     */
    public function model(array $row)
    {
        if ($row[0] == "Тема в отчёте")
            return null;

        $dateTime = Carbon::parse(Date::excelToDateTimeObject(intval($row[2]))->format('Y-m-d') . ' ' . Date::excelToDateTimeObject(floatval($row[3]))->format('H:i:s'));

        if ($row[1] == null){
            var_dump('row parse error: ', $row);
            return null;
        }

        return new \App\Models\Feedback(['tema_v_otcete' => $row[0],
            'subjekt' => $row[1],
            'date_with_time' => $dateTime->format('Y-m-d H:i:s'),
            'istocnik' => $row[4],
            'url_post' => $row[5],
            'url_kommentarii' => $row[6],
            'avtor' => $row[7],
            'kolicestvo_podpiscikov' => ((int)$row[8] == 0) ? 0 :(int) $row[8],
            'gorod' => $row[10],
            'raion' => $row[11],
            'ocenka_krai' => $row[12],
            'krai_glava' => $row[13],
            'ocenka_glavi' => $row[15],
            'kommentarii' => ((int)$row[17] == 0) ? 0 : (int)$row[17],
            'laiki' => ((int)$row[18] == 0) ? 0 : (int)$row[18],
            'reposti' => ((int)$row[19] == 0) ? 0 : (int)$row[19],
            'prosmotri' => ((int)$row[20] == 0) ? 0 : (int)$row[20],
            'ssilka_na_profil' => $row[21],
        ]);

    }
}

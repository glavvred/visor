<?php

declare(strict_types = 1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Positive extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $qry = DB::table('excel_table');
        $qry->select(DB::raw('ocenka_krai as colour, COUNT(ocenka_krai) as count'));

        $qry = app('App\Http\Controllers\ImportExcel')->filter($request, $qry);


        $themes = $qry->groupBy('colour')
            ->orderBy('count', 'DESC')
            ->get()
            ->toArray();

        $count = $countOther = $fullCount = 0;
        foreach ($themes as $theme) {
            if ($count > 7) {
                $countOther += $theme->count;
                continue;
            }
            if ($theme->count > 0) {
                $labels[] = $theme->colour;
                $counts[] = $theme->count;
            }
            $count++;
            $fullCount += $theme->count;
        }

        foreach ($labels as $idx => $label) {
            $percent = $counts[$idx] / $fullCount * 100;
            $labels[$idx] .= "(" . round($percent, 2) . '%)';
        }


        return Chartisan::build()
            ->labels($labels ?? [])
            ->dataset('Тема в отчете', $counts ?? []);
    }
}
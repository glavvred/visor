<?php

declare(strict_types=1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     * @param Request $request
     * @return Chartisan
     */
    public function handler(Request $request): Chartisan
    {

        $qry = DB::table('excel_table');
        $qry->select(DB::raw('tema_v_otcete as name, COUNT(tema_v_otcete) as count'));
        $qry = app('App\Http\Controllers\ImportExcel')->filter($request, $qry);

        $themes = $qry->groupBy('tema_v_otcete')
            ->orderBy('count', 'DESC')
            ->get()
            ->toArray();

        $count = $fullCount = $countOther = 0;
        foreach ($themes as $theme) {
            if ($count > 4) {
                $countOther += $theme->count;
                continue;
            }
            if ($theme->count > 0) {
                $labels[] = $theme->name;
                $counts[] = $theme->count;
            }
            $fullCount += $theme->count;
            $count++;
        }

        foreach ($labels as $idx => $label) {
            $percent = $counts[$idx] / $fullCount * 100;
            $labels[$idx] .= "(" . round($percent, 2) . '%)';
        }

        if ($countOther > 0 ) {
            $labels[] = 'Остальные';
            $counts[] = $countOther;
        }
        return Chartisan::build()
            ->labels($labels ?? [])
            ->dataset('Тема в отчете', $counts ?? []);
    }
}

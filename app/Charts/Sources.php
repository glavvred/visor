<?php

declare(strict_types=1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sources extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $qry = DB::table('excel_table');
        $qry->select(DB::raw('istocnik, COUNT(istocnik) as cC '));
        $qry = app('App\Http\Controllers\ImportExcel')->filter($request, $qry);

        $sources = $qry
            ->groupBy('istocnik')
            ->get()
            ->toArray();

        $count = $fullCount = $countOtherSources = 0;
        foreach ($sources as $source) {
            if ($count > 4) {
                $countOtherSources += $source->cC;
                continue;
            }

            if ($source->cC > 0) {
                $labelsSources[] = $source->istocnik;
                $countsSources[] = $source->cC;
            }

            $fullCount += $source->cC;
            $count++;
        }

        foreach ($labelsSources as $idx => $label) {
            $percent = $countsSources[$idx] / $fullCount * 100;
            $labelsSources[$idx] .= "(" . round($percent, 2) . '%)';
        }

        if ($countOtherSources > 0) {
            $labelsSources[] = 'Остальные';
            $countsSources[] = $countOtherSources;
        }

        if (!empty($labelsSources)) {
        return Chartisan::build()
            ->labels($labelsSources)
            ->dataset('Источники', $countsSources);
        }
        return Chartisan::build()
            ->labels([])
            ->dataset('Источники', []);

    }
}
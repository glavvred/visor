<?php

declare(strict_types=1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $qry = DB::table('excel_table');
        $qry->select(DB::raw('gorod, COUNT(gorod) as cC'));

        $qry = app('App\Http\Controllers\ImportExcel')->filter($request, $qry);

        $cities = $qry
            ->groupBy('gorod')
            ->whereNotNull('gorod')
            ->orderBy('cC', 'DESC')
            ->get()
            ->toArray();

        $count = $fullCount = $countsCitiesOther = 0;
        foreach ($cities as $city) {
            if ($count > 3) {
                $countsCitiesOther += $city->cC;
                continue;
            }

            if ($city->cC > 0) {
                $labelsCities[] = $city->gorod;
                $countsCities[] = $city->cC;
            }

            $count++;
            $fullCount += $city->cC;
        }

        foreach ($labelsCities as $idx => $label) {
            $percent = $countsCities[$idx] / $fullCount * 100;
            $labelsCities[$idx] .= "(" . round($percent, 2) . '%)';
        }

        
        if ($countsCitiesOther > 0) {
            $labelsCities[] = 'Остальные';
            $countsCities[] = $countsCitiesOther;
        }

        if (!empty($labelsCities)) {
            return Chartisan::build()
                ->labels($labelsCities)
                ->dataset('Города', $countsCities);
        }
        return Chartisan::build()
            ->labels([])
            ->dataset('Города', []);
    }
}
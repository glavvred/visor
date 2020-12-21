<?php

namespace App\Http\Controllers;

use App\Imports\FeedbackImport;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcel extends Controller
{
    public function index()
    {
        $tema = DB::table('excel_table')->distinct('tema_v_otcete')->get();
        return view('import_excel')->with(['tema' => $tema]);
    }

    public function show()
    {
        return view('import_excel1');
    }

    public function charts()
    {
        return view('charts');
    }

    public function upload()
    {
        return view('excel_upload');
    }

    public function json_search(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select(DB::raw('*, ROUND((kommentarii + laiki + reposti) / prosmotri, 4) as vovlechennost '));

        $qry = $this->filter($request, $qry);
//        var_dump($qry->toSql());

        $res['count'] = $qry->count();

        $qry->limit($request->input('limit') ? 100 : 0)
            ->offset($request->input('offset') ?? 0);

        $res['items'] = $qry->get();

        return response()->json($res);
    }

    public function filter($request, $qry)
    {
        if (!empty($request->input('startdate'))) {
            $date = Carbon::createFromFormat('d/m/Y', $request->input('startdate'))->format('Y-m-d 00:00:00');
            $qry->whereRaw("date_with_time >= '" . $date . "'");
        }
        if (!empty($request->input('enddate'))) {
            $date = Carbon::createFromFormat('d/m/Y', $request->input('enddate'))->format('Y-m-d 23:59:59');
            $qry->whereRaw("date_with_time <= '" . $date . "'");
        }

        if (!empty($request->input('tema_v_otcete'))) {
            $themes = explode(',', $request->input('tema_v_otcete'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('tema_v_otcete', $theme);
                }
            });
        }

        if (!empty($request->input('theme'))) {
            $themes = explode(',', $request->input('theme'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('tema_v_otcete', $theme);
                }
            });
        }

        if (!empty($request->input('subject'))) {
            $themes = explode(',', $request->input('subject'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('subject', $theme);
                }
            });
        }
        if (!empty($request->input('subjekt'))) {
            $themes = explode(',', $request->input('subjekt'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('subjekt', $theme);
                }
            });
        }

        if (!empty($request->input('istocnik'))) {
            $themes = explode(',', $request->input('istocnik'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('istocnik', $theme);
                }
            });
        }
        if (!empty($request->input('ocenka_krai'))) {
            $themes = explode(',', $request->input('ocenka_krai'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('ocenka_krai', $theme);
                }
            });
        }

        if (!empty($request->input('city'))) {
            $themes = explode(',', $request->input('city'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('gorod', $theme);
                }
            });
        }

        if (!empty($request->input('gorod'))) {
            $themes = explode(',', $request->input('gorod'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('gorod', $theme);
                }
            });
        }

        if (!empty($request->input('raion'))) {
            $themes = explode(',', $request->input('raion'));
            $qry->where(function ($query) use ($themes) {
                foreach ($themes as $theme) {
                    $query->orWhere('raion', $theme);
                }
            });
        }

        if (!empty($request->input('sort'))) {
            $qry->orderBy($request->input('sort'), $request->input('order'));
        }

        return $qry;

    }

    public function json_themes_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('tema_v_otcete')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];
        foreach ($qry->get() as $result) {
            $res[$result->tema_v_otcete] = $result->tema_v_otcete;
        }

        return response()->json($res);
    }

    public function json_subjects_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('subjekt')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];
        foreach ($qry->get() as $result) {
            $res[$result->subjekt] = $result->subjekt;
        }

        return response()->json($res);
    }

    public function json_sources_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('istocnik')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];
        foreach ($qry->get() as $result) {
            $res[$result->istocnik] = $result->istocnik;
        }

        return response()->json($res);
    }

    public function json_authors_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('avtor')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];

        foreach ($qry->take(300)->get() as $result) {
            $res[$result->avtor] = $result->avtor;
        }

        return response()->json($res);
    }

    public function json_cities_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('gorod')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];

        foreach ($qry->get() as $result) {
            $res[$result->gorod] = $result->gorod;
        }

        return response()->json($res);
    }

    public function json_regions_list(Request $request)
    {
        $qry = DB::table('excel_table');
        $qry->select('raion')->distinct();

        $qry = $this->filter($request, $qry);

        $res = [];

        foreach ($qry->get() as $result) {
            if (!empty($result->raion)) {
                $res[$result->raion] = $result->raion;
            }
        }

        return response()->json($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        if (empty($request->excel_uploaded_file)) {
            return back()->with('error', 'Файл пуст');
        }

        $file = $request->excel_uploaded_file->store('/excels', 'public');

        try {
            Excel::import(new FeedbackImport(), storage_path() . '/' . $file);
        } catch (QueryException $exception) {
            var_dump($exception->getMessage());
        }

        return back()->with('success', 'Успешно загружен файл: ' . $request->excel_uploaded_file->getClientOriginalName());
    }

}

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/import_excel', 'ImportExcel@index')->name('excel.show')->middleware('admin.user');
    Route::get('/import_excel/charts', 'ImportExcel@charts')->name('excel.charts')->middleware('admin.user');
    Route::get('/excel_multiselect', 'ImportExcel@show')->name('excel.show.multiselect')->middleware('admin.user');
    Route::get('/json_search', 'ImportExcel@json_search')->name('excel.json.search');
    Route::get('/json_themes_list', 'ImportExcel@json_themes_list')->name('excel.json.themes_list');
    Route::get('/json_subjects_list', 'ImportExcel@json_subjects_list')->name('excel.json.subjects_list');
    Route::get('/json_sources_list', 'ImportExcel@json_sources_list')->name('excel.json.sources_list');
    Route::get('/json_authors_list', 'ImportExcel@json_authors_list')->name('excel.json.authors_list');
    Route::get('/json_cities_list', 'ImportExcel@json_cities_list')->name('excel.json.cities_list');
    Route::get('/json_regions_list', 'ImportExcel@json_regions_list')->name('excel.json.regions_list');
    Route::post('/import_excel/import', 'ImportExcel@import')->name('excel.upload')->middleware('admin.user');
    Route::get('/import_excel/upload', 'ImportExcel@upload')->name('excel.upload.form')->middleware('admin.user');
});

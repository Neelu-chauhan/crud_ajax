<?php

use App\Models\countriesModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

Route::get('/', function () {
    $countries = countriesModel::pluck('countries_name','id')->toArray();
    return view('welcome',compact('countries'));
});

Route::controller(CrudController::class)->prefix('curd/')->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::get('show', 'show')->name('show');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::get('delete/{id}', 'delete')->name('delete');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\JobcardController;
use App\Http\Controllers\LiveController;
use Illuminate\Support\Facades\Auth;
  
Route::get('/', function () { return view('welcome');}); 
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/addnewjob', [JobcardController::class, 'newjob'])->name('newjob');
Route::get('/joblist', [JobcardController::class, 'joblist'])->name('joblist');
Route::get('/job-detail/{id}', [JobcardController::class, 'jobdetail'])->name('jobdetail');
Route::get('/jobdetail_remove/{id}', [JobcardController::class, 'jobdetail_remove'])->name('jobdetail_remove');
Route::get('/joblist_remove/{id}', [JobcardController::class, 'joblist_remove'])->name('joblist_remove');
Route::post('/jobsave', [JobcardController::class, 'jobsave'])->name('jobsave');
Route::post('/object_detailsave', [JobcardController::class, 'object_detailsave'])->name('object_detailsave');
Route::post('/colorshade_detailsave', [JobcardController::class, 'colorshade_detailsave'])->name('colorshade_detailsave');

Route::post('/jobdetail_live', [JobcardController::class, 'jobdetail_live'])->name('jobdetail_live');
Route::get('/liveview', [LiveController::class, 'liveview'])->name('liveview');
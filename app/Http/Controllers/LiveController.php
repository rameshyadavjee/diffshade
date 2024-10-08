<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function liveview(Request $request)
    {
        try {

            return view('liveview');
 
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            Log::error('QueryException: ' . $e->getMessage(), [
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'code' => $e->getCode(),
            ]);
            Session::flash('reservematter-error', 'Internal Server Error. Please try again later.');
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            Session::flash('reservematter-error', 'An unexpected error occurred. Please try again later.');
        }
    }
 
 
}

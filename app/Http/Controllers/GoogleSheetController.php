<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $rows = Sheets::spreadsheet('19qU0gC4GhEfEwZzYL7rMmoA7onZOexxou-CqTa6DcVE')
        ->sheet('DPR')
        ->get();
            $rows = collect($rows);
            $header = $rows->pull(0);
            $values = Sheets::collection(header: $header, rows: $rows);
            $data = $values->toArray();             
        return view('performance', ['data' => $data]);
    }

    public function update(Request $request)
    {
        $code = $request->input('code');
        // Process the input code and update it with some data
        
        // Retrieve all rows from the specified Google Sheets document and sheet.        
        Sheets::spreadsheet('19qU0gC4GhEfEwZzYL7rMmoA7onZOexxou-CqTa6DcVE')
        ->sheet('DPR')        
        ->range('B2')
        ->update([[$code]]);

        // Flash the updated data to the session
        return redirect('/home');

    }
}

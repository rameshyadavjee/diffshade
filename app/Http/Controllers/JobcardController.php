<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Differenceshading;
use Illuminate\Support\Facades\Session;
use App\Models\DiffShadeDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class JobcardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newjob()
    {     
        return view('newjob');
    }
    public function jobsave(Request $request)
    {
        try {           
            
            $jobcard_no = $request->jobcard_no;
            $request->validate([
                'jobcard_no' => 'required',
                'upload' => 'required|file|mimes:jpg,jpeg,pdf'
            ]);
            
            if ($request->hasFile('upload')) {                
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = 'original.' . $extension; // Standardize saved file name
            
                // Move the uploaded file
                $request->file('upload')->move(public_path('store/' . $jobcard_no . '/'), $fileName);
            
                // Save data to the database
                $userdata = new Differenceshading;
                $userdata->jobcard_no = $request->jobcard_no;
                $userdata->dept = $request->dept;
                $userdata->uploaded_by = Auth::user()->id . '-' . Auth::user()->name;
                $userdata->original_image = $fileName;
                $data = $userdata->save();
            
               // Execute Python script if file is a PDF
                if ($extension == 'pdf') {
                    
                    $scriptPath = 'C:\\laragon\\www\\diffshade\\public\\extact.py';
                    $jobcard_no = escapeshellarg($request->jobcard_no);
                    $command = shell_exec('python ' . escapeshellarg($scriptPath) . ' ' . $jobcard_no);
                    Log::info("Python script output: " . $command);                    
                }
               
            }           

            if ($data  > 0) {
                Session::flash('success', 'Added successfully');
                return redirect('joblist');
            } else {
                Session::flash('warning', 'Something went wrong');
                return redirect('joblist');
            }

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

    public function jobdetail_remove($id)
    {
        $jobcard = DiffShadeDetail::find($id);

        if ($jobcard) {
            $jobfolder = $jobcard->jobcard_no;
            $path = public_path('store\\' . $jobfolder . '\\');

            $uploaded_image_path = $path . $jobcard->uploaded_image;
            $output_image_path = $path . $jobcard->output_image;

            $del = $jobcard->delete();

            
            if ($del == 1) {
                
                if ($jobcard->uploaded_image != "") {
                    if (file_exists($uploaded_image_path)) {
                        unlink($uploaded_image_path);                        
                    }
                }

                if ($jobcard->output_image != "") {
                    if (file_exists($output_image_path)) {
                        unlink($output_image_path);                        
                    }
                }

                Session::flash('reservematter-warning', 'Removed successfully');
            } else {
                Session::flash('reservematter-warning', 'Failed to delete record');
            }

            return redirect()->back();
        } else {
            Session::flash('reservematter-warning', 'Record not found');
            return redirect()->back();
        }
    }

    public function joblist_remove($id)
    {

        // Find the job card by its ID
        $diffshading = Differenceshading::find($id);

        if ($diffshading) {

            $jobcard_no =  $diffshading->jobcard_no;

            $jobpath = public_path('store/' . $jobcard_no);

            if (File::exists($jobpath)) {
                try {
                    // Delete the job card
                    DiffShadeDetail::where('jobcard_no', $jobcard_no)->delete();
                    $diffshading->delete();

                    File::deleteDirectory(public_path('store/' . $jobcard_no)); //deleting directory using the storage facade  
                    Session::flash('reservematter-warning', 'Removed successfully');
                    return redirect()->back();
                } catch (ValidationException $e) {
                    Session::flash('reservematter-warning', 'Failed to delete directory');
                }
            } else {
                Session::flash('reservematter-warning', 'Directory does not exist.');
                return redirect()->back();
            }
        }
    }

    public function jobdetail($id)
    {
        $original_data =  Differenceshading::where('jobcard_no', $id)->orderby('id', 'desc')->get();
        $data_arrays =  DiffShadeDetail::where('jobcard_no', $id)->orderby('id', 'desc')->get();
        return view('joblist-detail', ['data_arrays' => $data_arrays, 'original_data' => $original_data]);
    }

    public function joblist()
    {
        $data_arrays =  Differenceshading::orderby('id', 'desc')->get();
        return view('joblist', ['data_arrays' => $data_arrays]);
    }
    
    public function object_detailsave(Request $request)
    {
        try {
            $path = $request->jobcard_no;
            // Validate the uploaded file
            $request->validate([
                'upload' => 'required|file|mimes:jpg,jpeg,png'
            ]);

            if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $name = (new \DateTime())->format('Y-m-d_H-i-s');

                $fileName = $name . '.' . $extension;
                $request->file('upload')->move(public_path('store/' . $path . '/'), $fileName);

                $userdata = new DiffShadeDetail;
                $userdata->jobcard_no = $request->jobcard_no;
                $userdata->created_by = Auth::user()->id . '-' . Auth::user()->name;
                $userdata->output_image = '';
                $userdata->uploaded_image = $fileName;
                $data =  $userdata->save();
                $lastinsertedId = $userdata->id;

                // Prepare command to execute Python script
                $jobcard_no = escapeshellarg($request->jobcard_no);
                $image_name = escapeshellarg($fileName);
                $original_image =  escapeshellarg($request->original_image);

                if($request->comparetype == 'blackwhite') {
                    $command = shell_exec("python " . escapeshellarg(public_path('objectdifference.py')) . " $jobcard_no $lastinsertedId $image_name $original_image");
                }elseif($request->comparetype == 'coloured') { 
                    $command = shell_exec("python " . escapeshellarg(public_path('original-objectdifference.py')) . " $jobcard_no $lastinsertedId $image_name $original_image");
                }
                
                

                Log::info("Python script output: " . $command);
            }

            if ($data  > 0) {
                Session::flash('reservematter-success', 'Uploaded successfully');
                return redirect()->back();
            } else {
                Session::flash('reservematter-warning', 'Something went wrong');
                return redirect()->back();
            }
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

    public function colorshade_detailsave(Request $request)
    {
        try {
            $path = $request->jobcard_no;
            // Validate the uploaded file
            $request->validate([
                'upload' => 'required|file|mimes:jpg,jpeg,png'
            ]);

            if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $name = (new \DateTime())->format('Y-m-d_H-i-s');

                $fileName = $name . '.' . $extension;
                $request->file('upload')->move(public_path('store/' . $path . '/'), $fileName);

                $userdata = new DiffShadeDetail;
                $userdata->jobcard_no = $request->jobcard_no;
                $userdata->created_by = Auth::user()->id . '-' . Auth::user()->name;
                $userdata->output_image = '';
                $userdata->uploaded_image = $fileName;
                $data =  $userdata->save();
                $lastinsertedId = $userdata->id;

                // Prepare command to execute Python script
                $jobcard_no = escapeshellarg($request->jobcard_no);
                $image_name = escapeshellarg($fileName);
                $original_image =  escapeshellarg($request->original_image);

                $command = shell_exec("python " . escapeshellarg(public_path('colorshadedifference.py')) . " $jobcard_no $lastinsertedId $image_name $original_image");

                Log::info("Python script output: " . $command);
            }

            if ($data  > 0) {
                Session::flash('reservematter-success', 'Uploaded successfully');
                return redirect()->back();
            } else {
                Session::flash('reservematter-warning', 'Something went wrong');
                return redirect()->back();
            }
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

    public function jobdetail_live(Request $request)
    {
        try {
            //HAO00198      
            // Prepare command to execute Python script
            $jobcard_no = escapeshellarg($request->jobcard_no);
            $original_image =  escapeshellarg($request->original_image);
            $created_by = Auth::user()->id . '-' . Auth::user()->name;

            shell_exec("python " . escapeshellarg(public_path('live.py')) . " $jobcard_no $original_image $created_by");

            #Log::info("Python script output: " . $command);                          
            Session::flash('reservematter-success', 'Captured successfully');
            return redirect()->back();
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

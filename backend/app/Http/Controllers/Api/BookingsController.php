<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingsController extends Controller
{

    public $errorOutput = array(
        'status' => 'error',
        'message' => 'Not updated successfully',
        'custom' => ''
    );

    public $successOutput = array(
        'status' => 'success',
        'message' => 'updated successfully',
        'custom' => ''
    );

    public function output($array = null)
    {
        echo json_encode($array);
        exit();
    }
    public function index(){

    }

    public function store(Request $request){
            // try{
                if ($request->isMethod('post'))
                {
                    
                    $validator = $this->validate($request, [
                   
                    'slot_type' => 'required',
                     'mobile'=>  'required',
                     'address'=>  'required']);
    
                    $input = $request->all();
                   
                    $uniqueId= time().'-'.mt_rand();
                    $input['uuid'] = $uniqueId;
                    
                    $booking = Booking::create($input);
                    if ($booking)
                    {
                        $this->successOutputData['data'] = $booking;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $this->errorOutput['custom'] = "Record not Inserted";
                        $this->output($this->errorOutput);
                    }
    
                }
            // } catch (\Exception $e) {
            //     return response()->json(['error' => 'Page not found'], 404);
    
            // }
        

    }
}

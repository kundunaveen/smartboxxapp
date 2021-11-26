<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\availability;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

class BookingsController extends Controller
{

    public $errorOutput = array(
        'status' => 'error',
        'message' => 'successfully.',
        'custom' => ''
    );

    public $successOutput = array(
        'status' => 'success',
        'message' => 'successfully.',
        'custom' => ''
    );

    public function output($array = null)
    {
        echo json_encode($array);
        exit();
    }
    public function index()
    {

    }

    public function store(Request $request)
    {
        // try{
        if ($request->isMethod('post'))
        {
             
            
            $validator = $this->validate($request, [
            'slot_type' => 'required', 'mobile' => 'required', 'address' => 'required']);
            $input = $request->all();
               
            if ($input['slot_type'] == '1')
            {
                // $input['start_date'] = strpos($input['range_date'][0], "T") ? substr($input['range_date'][0], 0, strpos($input['range_date'][0], "T")) : $input['range_date'][0];
                // $input['end_date'] = strpos($input['range_date'][1], "T") ? substr($input['range_date'][1], 0, strpos($input['range_date'][1], "T")) : $input['range_date'][1];
                $input['start_date'] = Carbon::parse($request['range_date'][0])->setTimezone('Asia/Kolkata')->toDateString();
                $input['end_date'] =Carbon::parse($request['range_date'][1])->setTimezone('Asia/Kolkata')->toDateString();
                $alreadyExist = availability::WhereDate('date',$input['start_date'])
                                             ->orWhereDate('date',$input['end_date'])
                                             ->orwherebetween('date', [$input['start_date'],$input['end_date']])
                                             ->get();


                if (count($alreadyExist) > 0)
                {
                    $this->errorOutput['custom'] = "Slot not available Please select another date";
                    $this->output($this->errorOutput);
                }

            }
            else
            {
                $input['start_date'] = $input['start_date'];
                
                $alreadyExist = availability::whereDate('date',$input['start_date'])->get();

                if (count($alreadyExist) > 0)
                {
                    $this->errorOutput['custom'] = "Slot not available Please select another date";
                    $this->output($this->errorOutput);
                }

            }

            $uniqueId = time() . '-' . mt_rand();
            $input['uuid'] = $uniqueId;
            $input['user_id'] = Auth::user()->id;

            $booking = Booking::create($input);
            if ($booking)
            {
                if($input['slot_type'] == '1'){
                    $begin = new DateTime($input['start_date']);
                    $end = new DateTime($input['end_date']);
                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                    foreach($daterange as $date){
                    
                     $availability['booking_id'] = $booking->id;
                     $availability['date'] =  $date->format("Y-m-d");

                     availability::create($availability);
                    }
                }else{
                    $availability['booking_id'] = $booking->id;
                    $availability['date'] =  $input['start_date'];
                    availability::create($availability);

                }
               
              
                $this->successOutputData['status'] = 'success';
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

    public function getBooking()
    {

        $booking = Booking::with('device')->get();
        if ($booking)
        {
            $this->successOutputData['data'] = $booking;
            $this->output($this->successOutputData);
        }
        else
        {
            $this->errorOutput['custom'] = "Record not found";
            $this->output($this->errorOutput);
        }

    }

    public function delete(Request $request, $id)
    {

        $booking = Booking::find($id);

        if ($booking)
        {
            $booking->delete();
            $this->errorOutput['custom'] = "Record delete successfully";
            $this->successOutputData['data'] = $booking;
            $this->output($this->successOutputData);
        }
        else
        {
            $this->errorOutput['custom'] = "Record not found";
            $this->output($this->errorOutput);
        }
    }

    public function view(Request $request, $id)
    {
        try
        {
            if ($request->isMethod('get'))
            {

                $user = Booking::find($id);

                if ($user)
                {
                    $this->successOutputData['status'] = 'success';
                    $this->successOutputData['data'] = $user;
                    $this->output($this->successOutputData);
                }
                else
                {
                    $this->errorOutput['custom'] = "Record not found";
                    $this->output($this->errorOutput);
                }

            }
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => 'Page not found'], 404);

        }

    }

    public function update(Request $request, $id)
    {
        // try{
        if ($request->isMethod('put'))
        {
            $booking = Booking::find($id);
            $input = $request->all();
            if ($input['slot_type'] == '1')
            {
                $input['start_date'] = Carbon::parse($request['range_date'][0])->setTimezone('Asia/Kolkata')->toDateString();
                $input['end_date'] =Carbon::parse($request['range_date'][1])->setTimezone('Asia/Kolkata')->toDateString();
                // $input['start_date'] = strpos($input['range_date'][0], "T") ? substr($input['range_date'][0], 0, strpos($input['range_date'][0], "T")) : $input['range_date'][0];
                // $input['end_date'] = strpos($input['range_date'][1], "T") ? substr($input['range_date'][1], 0, strpos($input['range_date'][1], "T")) : $input['range_date'][1];

                $alreadyExist = availability::where('booking_id','!=',$id)->whereDate('date', '=', $input['start_date'])->get();
                if (count($alreadyExist) > 0)
                {
                    $this->errorOutput['custom'] = "Slot not available Please select another date";
                    $this->output($this->errorOutput);
                }else{
                
                        $existFind = availability::where(['booking_id'=>$id])->get();
                        if(count($existFind)>0){
                            foreach( $existFind as $val){ 
                                availability::where('booking_id', '=', $val->booking_id)->delete();
                            }

                        }
                    
                     
                        $begin = new DateTime($input['start_date']);
                        $end = new DateTime($input['end_date']);
                        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
    
                        foreach($daterange as $date){
                         $availability['booking_id'] = $id;
                         $availability['date'] =  $date->format("Y-m-d");
                         availability::create($availability);
                        }
                   
                    }
                   
                

                $booking->update(['slot_type' => $input['slot_type'],
                                   'device_id' => $input['device_id'],
                                    'address' => $input['address'],
                                     'mobile' => $input['mobile'],
                                      'start_date' => $input['start_date'], 'end_date' => $input['end_date'] ]);

            }
            else
            {
                $input['start_date'] = $input['start_date'];
                $alreadyExist = availability::where('booking_id','!=',$id)->whereDate('date', '=', $input['start_date'])->get();
                if (count($alreadyExist) > 0)
                {
                    $this->errorOutput['custom'] = "Slot not available Please select another date";
                    $this->output($this->errorOutput);
                }else{
                    $existFind = availability::where(['booking_id'=>$id])->get();
                    if(count($existFind)>0){
                        foreach( $existFind as $val){ 
                            availability::where('booking_id', '=', $val->booking_id)->delete();
                        }

                    }
                    $availability['booking_id'] = $id;
                    $availability['date'] =  $input['start_date'];
                    availability::create($availability);
                    
                }

                $booking->update(['slot_type' => $input['slot_type'], 
                                 'device_id' => $input['device_id'],
                                  'address' => $input['address'],
                                   'mobile' => $input['mobile'], 
                                   'start_date' => $input['start_date'], 'end_date' => NULL]);
            }

            if ($booking)
            {

                $this->successOutputData['status'] = "success";
                $this->successOutputData['custom'] = "Record update";
                $this->successOutputData['data'] = $booking;
                $this->output($this->successOutputData);
            }
            else
            {
                $this->errorOutput['custom'] = "Record not update";
                $this->output($this->errorOutput);
            }

        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Page not found'], 404);
        // }
        
    }
}


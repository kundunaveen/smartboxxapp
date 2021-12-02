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
use Validator;


class BookingsController extends Controller
{

    // public $errorOutput = array(
    //     'status' => 'error',
    //     'message' => 'successfully.',
    //     'custom' => ''
    // );

    // public $successOutput = array(
    //     'status' => 'success',
    //     'message' => 'successfully.',
    //     'custom' => ''
    // );



    // public function output($array = null)
    // {
    //     echo json_encode($array);
    //     exit();
    // }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = ['success' => true, 'data' => $result, 'message' => $message,'code'=>'200' ];

        return response()->json($response, 200);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponseError($result, $message)
    {
        $response = ['success' => true, 'data' => $result, 'message' => $message,'code'=>'201'];

        return response()->json($response, 201);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        try{
            $response = ['success' => false, 'message' => $error,'code'=>$code ];

            if (!empty($errorMessages))
            {
                $response['data'] = $errorMessages;
            }

          return response()->json($response, $code);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);

        }
    }

   

    public function store(Request $request)
    {
        try{
        if ($request->isMethod('post'))
        {
             
        $validator = Validator::make($request->all(), [
            'slot_type' => 'required', 'mobile' => 'required', 'address' => 'required']);
            if ($validator->fails()) {
                return response()->json(['Status' => 
              false,'message'=>$validator->errors()->first(),'Data' => '','Status_code' =>"401" ]);            
            }

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
                     return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date');
                }

            }
            else
            {
                $input['start_date'] = $input['start_date'];
                
                $alreadyExist = availability::whereDate('date',$input['start_date'])->get();

                if (count($alreadyExist) > 0)
                {
                   return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date');

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
                return $this->sendResponse($booking, 'Booking add successfully');
              
              
            }
            else
            {
                return $this->sendResponseError($booking, 'Booking not add successfully');

            }

        }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
        

        
    }

    public function getBooking()
    {
        try { 
        $booking = Booking::with('device')->get();
        if ($booking) {
            return $this->sendResponse($booking, 'Booking List');
        } else {
            return $this->sendResponse($booking, 'No record found');
        }
    }
    catch(\Exception $e) {
        return response()->json(['error' => 'Somthig is wrong.'], 404);
    }    

    }

    public function delete(Request $request, $id)
    {

        $booking = Booking::find($id);

        if ($booking)
        {
            $booking->delete();
            return $this->sendResponse($booking, 'Record delete successfully');
            
        }
        else
        {
            return $this->sendResponseError($booking, 'Record not delete successfully');
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
                    return $this->sendResponse($user, 'Booking List');
                }
                else
                {
                    return $this->sendResponseError($user, 'Record not found');

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
        try{
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
                    return $this->sendResponse($alreadyExist, 'Slot not available Please select another date');
                   
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
                    return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date');
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
                return $this->sendResponse($booking, 'Record update');

            }
            else
            {
                return $this->sendResponseError($booking, 'Record not update');
            }

        }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
        
    }
}


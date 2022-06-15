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
use App\Models\Device;
use App\Models\DeviceImages;

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
        $response = ['success' => true, 'data' => $result, 'message' => $message, 'code' => '200'];

        return response()->json($response, 200);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponseError($result, $message)
    {
        $response = ['success' => true, 'data' => $result, 'message' => $message, 'code' => '201'];

        return response()->json($response, 201);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        try {
            $response = ['success' => false, 'message' => $error, 'code' => $code];

            if (!empty($errorMessages)) {
                $response['data'] = $errorMessages;
            }

            return response()->json($response, $code);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }



    public function store(Request $request)
    {
        // try {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'slot_type' => 'required',
                // 'mobile' => 'required', 
                // 'address' => 'required', 
                // 'code' => 'required',
                // 'country' =>  'required',
                // 'state' =>  'required',
                // 'city' =>  'required',
                // 'zip' =>  'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }

            $input = $request->all();

            if ($input['slot_type'] == '1') {
                // $input['start_date'] = strpos($input['range_date'][0], "T") ? substr($input['range_date'][0], 0, strpos($input['range_date'][0], "T")) : $input['range_date'][0];
                // $input['end_date'] = strpos($input['range_date'][1], "T") ? substr($input['range_date'][1], 0, strpos($input['range_date'][1], "T")) : $input['range_date'][1];
                $input['start_date'] = Carbon::parse($request['range_date'][0])->setTimezone('Asia/Kolkata')->toDateString();
                $input['end_date'] = Carbon::parse($request['range_date'][1])->setTimezone('Asia/Kolkata')->toDateString();
                $alreadyExist = availability::WhereDate('date', $input['start_date'])
                    ->orWhereDate('date', $input['end_date'])
                    ->orwherebetween('date', [$input['start_date'], $input['end_date']])
                    ->get();


                if (count($alreadyExist) > 0) {
                    return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date');
                }
            } else {
                $s = $input['start_time'];
                $e = $input['end_time'];
                if ($s == $e) {
                    return $this->sendResponseError($s . '|' . $e, 'Slot time should not be same');
                }



                if ((strpos($s, 'am') !== false) && (strpos($e, 'am') !== false)) {
                    $s_new  = str_replace("am", "", $s);
                    $e_new  = str_replace("am", "", $e);

                    if ($s_new > $e_new) {
                        return $this->sendResponseError($s . '|' . $e, 'Start time should be greter then end time');
                    }
                }

                if ((strpos($s, 'pm') !== false) && (strpos($e, 'pm') !== false)) {
                    $s_new  = str_replace("pm", "", $s);
                    $e_new  = str_replace("pm", "", $e);
                    if ($s_new > $e_new) {
                        return $this->sendResponseError($s . '|' . $e, 'Start time should be greter then end time');
                    }
                }





                $alreadyExist = availability::whereTime('start_time', '<=',  date('H:i:s', strtotime($s)))->whereTime('end_time', '>=',  date('H:i:s', strtotime($e)))->WhereDate('date', $input['start_date'])->get();

                if (count($alreadyExist) > 0) {
                    return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date and time');
                }
            }

            $uniqueId = time() . '-' . mt_rand();
            $input['uuid'] = $uniqueId;
            $input['user_id'] = $request['user_id'];

            $booking = Booking::create($input);
            if ($booking) {
                if ($input['slot_type'] == '1') {
                    $begin = new DateTime($input['start_date']);
                    $end = new DateTime($input['end_date']);
                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                    foreach ($daterange as $date) {

                        $availability['booking_id'] = $booking->id;
                        $availability['date'] =  $date->format("Y-m-d");

                        availability::create($availability);
                    }
                } else {

                    $availability['booking_id'] = $booking->id;
                    $availability['date'] =  $input['start_date'];
                    $availability['start_time'] =  date('H:i:s', strtotime($input['start_time']));
                    $availability['end_time'] = date('H:i:s', strtotime($input['end_time']));
                    availability::create($availability);
                }
                return $this->sendResponse($booking, 'Booking add successfully');
            } else {
                return $this->sendResponseError($booking, 'Booking not add successfully');
            }
        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Page not found'], 404);
        // }
    }

    public function getBooking(Request $request)
    {
        try {
            $query = Booking::with('device');

            if (isset($request['search']) && $request['search'] != null) {

                $query->where('uuid', 'LIKE', '%' . $request['search'] . '%');
            }

            $booking = $query->get();
            if ($booking) {
                return $this->sendResponse($booking, 'Booking List');
            } else {
                return $this->sendResponse($booking, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }

    public function delete(Request $request, $id)
    {

        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete();
            return $this->sendResponse($booking, 'Record delete successfully');
        } else {
            return $this->sendResponseError($booking, 'Record not delete successfully');
        }
    }

    public function view(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $user = Booking::find($id);
                if ($user) {
                    return $this->sendResponse($user, 'Booking List');
                } else {
                    return $this->sendResponseError($user, 'Record not found');
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // try{
        if ($request->isMethod('put')) {
            $booking = Booking::find($id);
            $input = $request->all();
            if ($input['slot_type'] == '1') {
                $input['start_date'] = Carbon::parse($request['range_date'][0])->setTimezone('Asia/Kolkata')->toDateString();
                $input['end_date'] = Carbon::parse($request['range_date'][1])->setTimezone('Asia/Kolkata')->toDateString();
                // $input['start_date'] = strpos($input['range_date'][0], "T") ? substr($input['range_date'][0], 0, strpos($input['range_date'][0], "T")) : $input['range_date'][0];
                // $input['end_date'] = strpos($input['range_date'][1], "T") ? substr($input['range_date'][1], 0, strpos($input['range_date'][1], "T")) : $input['range_date'][1];

                $alreadyExist = availability::where('booking_id', '!=', $id)->whereDate('date', '=', $input['start_date'])->get();
                if (count($alreadyExist) > 0) {
                    return $this->sendResponse($alreadyExist, 'Slot not available Please select another date');
                } else {

                    $existFind = availability::where(['booking_id' => $id])->get();
                    if (count($existFind) > 0) {
                        foreach ($existFind as $val) {
                            availability::where('booking_id', '=', $val->booking_id)->delete();
                        }
                    }


                    $begin = new DateTime($input['start_date']);
                    $end = new DateTime($input['end_date']);
                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                    foreach ($daterange as $date) {
                        $availability['booking_id'] = $id;
                        $availability['date'] =  $date->format("Y-m-d");
                        availability::create($availability);
                    }
                }



                $booking->update([
                    'slot_type' => $input['slot_type'],
                    // 'code' => $input['code'],
                    'device_id' => $input['device_id'],
                    // 'address' => $input['address'],
                    // 'country' => $input['country'],
                    // 'state' => $input['state'],
                    // 'city' => $input['city'],
                    // 'zip' => $input['zip'],
                    // 'mobile' => $input['mobile'],
                    'user_id' => $input['user_id'],
                    'start_date' => $input['start_date'],
                    'end_date' => $input['end_date']
                ]);
            } else {
                $input['start_date'] = $input['start_date'];
                $alreadyExist = availability::where('booking_id', '!=', $id)->whereDate('date', '=', $input['start_date'])->get();
                if (count($alreadyExist) > 0) {
                    return $this->sendResponseError($alreadyExist, 'Slot not available Please select another date');
                } else {
                    $existFind = availability::where(['booking_id' => $id])->get();
                    if (count($existFind) > 0) {
                        foreach ($existFind as $val) {
                            availability::where('booking_id', '=', $val->booking_id)->delete();
                        }
                    }
                    $availability['booking_id'] = $id;
                    $availability['date'] =  $input['start_date'];
                    availability::create($availability);
                }

                $booking->update([
                    'slot_type' => $input['slot_type'],
                    'device_id' => isset($input['device_id']) ? $input['device_id'] : $booking['device_id'],
                    // 'address' => isset($input['address']) ? $input['address'] : $booking['address'],
                    // 'mobile' => isset($input['mobile']) ? $input['mobile'] : $booking['mobile'],
                    // 'country' => isset($input['country']) ? $input['country'] : $booking['country'],
                    // 'state' => isset($input['state']) ? $input['state'] : $booking['state'],
                    // 'city' => isset($input['city']) ? $input['city'] : $booking['city'],
                    // 'zip' => isset($input['zip']) ? $input['zip'] : $booking['zip'],
                    // 'code' => isset($input['code']) ? $input['code'] : $booking['code'],
                    'start_date' => $input['start_date'],
                    'end_date' => NULL,
                    'user_id' => $input['user_id'],
                ]);
            }

            if ($booking) {
                return $this->sendResponse($booking, 'Record update');
            } else {
                return $this->sendResponseError($booking, 'Record not update');
            }
        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Page not found'], 404);
        // }

    }


    public function deviceList(Request $request)
    {
        try {
            $query = Device::with('images');
            if (isset($request['search']) && $request['search'] != null) {

                $query->where('name', $request['search']);
            }

            $device = $query->orderBy('id', 'desc')->get();
            if ($device) {
                return $this->sendResponse($device, 'device List');
            } else {
                return $this->sendResponse($device, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }


    public function deleteDevice(Request $request, $id)
    {

        $device = Device::find($id);

        if ($device) {
            $device->delete();
            return $this->sendResponse($device, 'Record delete successfully');
        } else {
            return $this->sendResponseError($device, 'Record not delete successfully');
        }
    }


    public function addDevice(Request $request)
    {
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [

                'name' => 'required|unique:device',
                'description' => 'required',


            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }

            $input = $request->all();

            $insert['name'] =  $input['name'];
            $insert['description'] =  $input['description'];
            $insert['lat'] =  $input['lat'];
            $insert['long'] =  $input['long'];
            $insert['address'] =  $input['address'];

            $device = Device::create($insert);

            $images =  $input['image'];
            if ($images) {
                foreach ($images as $key => $value) {
                    $imageName = time() . $key . '.' .    $value->extension();
                    $value->move(public_path('image'), $imageName);
                    $image['image'] =  $imageName;
                    $image['device_id'] =  $device->id;

                    DeviceImages::create($image);
                }
            }

            if ($device) {
                return $this->sendResponse($device, 'Device add successfully');
            } else {
                return $this->sendResponse($device, 'Device not add successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }
    public function statusChange(Request $request, $id)
    {
        try {
            if ($request->isMethod('put')) {

                $device = Device::find($id);
                if ($device) {
                    if ($device->status == 'active') {

                        $device->update(['status' => 'deactive']);
                        return $this->sendResponse($device, 'Status Update successfully');
                    } else {
                        $device->update(['status' => 'active']);
                        return $this->sendResponse($device, 'Status Update successfully');
                    }
                } else {
                    return $this->sendError('Not Found.', ['error' => 'Record not found please check given id']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function viewDevice(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $device = Device::find($id);
                if ($device) {
                    return $this->sendResponse($device, 'device details');
                } else {
                    return $this->sendResponseError($device, 'Record not found');
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function updateDevice(Request $request, $id = null)
    {

        // try {
        $id = $request['id'];

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:device,name,' . $id . ',id',



            ]);
            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }
            $device = Device::find($id);

            $input = $request->all();

            // if (isset($input['image'])) {
            //     $imageName = time() . '.' . $request->image->extension();
            //     $request->image->move(public_path('image'), $imageName);
            //     $input['image'] =  $imageName;
            // }

            if (isset($input['image'])) {
                foreach ($input['image'] as $key => $value) {
                    $imageName = time() . $key . '.' .    $value->extension();
                    $value->move(public_path('image'), $imageName);
                    $image['image'] =  $imageName;
                    $image['device_id'] = $id;
                    DeviceImages::create($image);
                }
            }

            if ($device) {
                $device->update([
                    'name' => $input['name'],
                    'description' => isset($input['description']) ? $input['description'] : $device->description,
                    'lat' => isset($input['lat']) ? $input['lat'] : $device->lat,
                    'long' => isset($input['long']) ? $input['long'] : $device->long,
                    'address' => isset($input['address']) ? $input['address'] : $device->address,
                    // 'image' => isset($input['image']) ? $input['image'] : $device->image,

                ]);
                return $this->sendResponse($device, 'Record update successfullly');
            } else {
                return $this->sendError('Not Found.', ['error' => 'Record not found of the given id.']);
            }
        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Page not found'], 404);
        // }
    }
}

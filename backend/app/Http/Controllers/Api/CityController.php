<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

use Illuminate\Support\Facades\Validator;

class CityController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = City::with(['country', 'state']);
            if (isset($request['search']) && $request['search'] != null) {

                $query->where('city', $request['search']);
            }
            $data = $query->get();
            if ($data) {
                return $this->sendResponse($data, 'City List');
            } else {
                return $this->sendResponseError($data, 'Record not found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_id' => 'required',
                'state_id' => 'required',
                'city' => 'required',



            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }
            $input = $request->all();
            $success = City::create($input);
            if ($success) {
                return $this->sendResponse($success, 'City add successfully');
            } else {
                return $this->sendResponseError($success, 'try again');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $success = City::with('country')->find($id);
            if ($success) {
                return $this->sendResponse($success, 'City details');
            } else {
                return $this->sendResponse($success, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'required',



        ]);

        if ($validator->fails()) {
            return response()->json(['Status' =>
            false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
        }
        $City = City::find($id);

        if ($City) {
            $input = $request->all();
            $City->update([
                'city' => isset($input['city']) ? $input['city'] : $City->name,
                'country_id' => isset($input['country_id']) ? $input['country_id'] : $City->country_id,
                'state_id' => isset($input['state_id']) ? $input['state_id'] : $City->country_id,
                'region' => isset($input['region']) ? $input['region'] : $City->country_id,


            ]);

            return $this->sendResponse($City, 'Record update successfullly');
        } else {
            return $this->sendError('Not Found.', ['error' => 'Record not found of the given id.']);
        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Somthig is wrong.'], 404);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $success = City::find($id);

            if ($success) {
                $success->delete();
                return $this->sendResponse($success, 'Record delete successfully');
            } else {
                return $this->sendResponseError($success, 'Record not found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }



    /**
     * Display a listing of the state by country id.
     *
     * @return \Illuminate\Http\Response
     */
    public function getState($id)
    {
        try {

            $data = State::where('country_id', '=', $id)->get();

            if ($data) {

                foreach ($data as $val) {
                    $temp['id'] = $val->id;
                    $temp['text'] = $val->name;
                    $res[] = $temp;
                }
                return $this->sendResponse($res, 'City List');
            } else {
                return $this->sendResponseError($data, 'Record not found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }
}

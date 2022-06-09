<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
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
    public function index()
    {
        try {
            $data = Country::get();
            if ($data) {
                return $this->sendResponse($data, 'Country List');
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
                'name' => 'required|unique:countries',
                'dial_code' => 'required|unique:countries',
                'code' => 'required|unique:countries',


            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }
            $input = $request->all();
            $success = Country::create($input);
            if ($success) {
                return $this->sendResponse($success, 'Country add successfully');
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
            $success = country::find($id);
            if ($success) {
                return $this->sendResponse($success, 'Country details');
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
            'name' => 'required|unique:countries,name,' . $id . ',id',
            'dial_code' =>  'required|unique:countries,dial_code,' . $id . ',id',
            'code' =>  'required|unique:countries,code,' . $id . ',id',


        ]);

        if ($validator->fails()) {
            return response()->json(['Status' =>
            false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
        }
        $country = Country::find($id);

        if ($country) {
            $input = $request->all();
            $country->update([
                'name' => isset($input['name']) ? $input['name'] : $country->name,
                'dial_code' => isset($input['dial_code']) ? $input['dial_code'] : $country->email,
                'code' => isset($input['code']) ? $input['code'] : $country->address,

            ]);

            return $this->sendResponse($country, 'Record update successfullly');
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
            $success = Country::find($id);

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
}

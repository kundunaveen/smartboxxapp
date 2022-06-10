<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
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
            $query = State::with('country');
            if (isset($request['search']) && $request['search'] != null) {

                $query->where('country_id', $request['search']);
            }
            $data = $query->get();
            if ($data) {
                return $this->sendResponse($data, 'State List');
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
                'name' => 'required',
                'country_id' => 'required',



            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }
            $input = $request->all();
            $success = State::create($input);
            if ($success) {
                return $this->sendResponse($success, 'State add successfully');
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
            $success = State::with('country')->find($id);
            if ($success) {
                return $this->sendResponse($success, 'State details');
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
            'name' => 'required',
            'country_id' =>  'required'



        ]);

        if ($validator->fails()) {
            return response()->json(['Status' =>
            false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
        }
        $State = State::find($id);

        if ($State) {
            $input = $request->all();
            $State->update([
                'name' => isset($input['name']) ? $input['name'] : $State->name,
                'country_id' => isset($input['country_id']) ? $input['country_id'] : $State->country_id,


            ]);

            return $this->sendResponse($State, 'Record update successfullly');
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
            $success = State::find($id);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
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
            $data = Page::get();
            if ($data) {
                return $this->sendResponse($data, 'Page List');
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
        // try {
        $validator = Validator::make($request->all(), [
            'detail' => 'required',
            'title' => 'required|unique:pages'
        ]);

        if ($validator->fails()) {
            return response()->json(['Status' =>
            false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
        }
        $input = $request->all();
        $success = Page::create($input);
        if ($success) {
            return $this->sendResponse($success, 'Page Type add successfully');
        } else {
            return $this->sendResponseError($success, 'try again');
        }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Somthig is wrong.'], 404);
        // }
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
            $success = Page::find($id);
            if ($success) {
                return $this->sendResponse($success, 'Page Type details');
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
        try {
            $validator = Validator::make($request->all(), [
                'detail' => 'required',
                'title' => 'required|unique:pages,title,' . $id . ',id',

            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }
            $Page = Page::find($id);

            if ($Page) {
                $input = $request->all();
                $Page->update([
                    'title' => isset($input['title']) ? $input['title'] : $Page->title,
                    'detail' => isset($input['detail']) ? $input['detail'] : $Page->name

                ]);

                return $this->sendResponse($Page, 'Record update successfullly');
            } else {
                return $this->sendError('Not Found.', ['error' => 'Record not found of the given id.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
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
            $success = Page::find($id);

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

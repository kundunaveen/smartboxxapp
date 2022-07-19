<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Str;
use Location;




class UsersController extends Controller
{


    public $paramMissings = array(
        'status' => 'error',
        'message' => 'params missing',
        'params' => ''
    );

    public function output($array = null)
    {
        return response()->json($array, 200);
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'

            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;

                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = ['success' => true, 'data' => $result, 'message' => $message,];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        try {
            $response = ['success' => false, 'message' => $error,];

            if (!empty($errorMessages)) {
                $response['data'] = $errorMessages;
            }

            return response()->json($response, $code);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails(Request $request)
    {

        return $this->sendResponse($request->user(), 'User login successfully.');
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'phone' =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'code' =>  'required',
                'country' =>  'required',
                'state' =>  'required',
                'city' =>  'required',
                'zip' =>  'required',

            ]);

            if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }

            $input = $request->all();

            $input['password'] = bcrypt('welcome');
            $user = User::create($input);
            $success['name'] = $user->name;
            if ($user) {
                return $this->sendResponse($user, 'User add successfully');
            } else {
                return $this->sendResponse($user, 'User not add successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, $id)
    {
        try {
            if ($request->isMethod('put')) {

                $user = User::find($id);
                if ($user) {
                    if ($user->status == 1) {

                        $user->update(['status' => '0']);
                        return $this->sendResponse($user, 'Status Update successfully');
                    } else {
                        $user->update(['status' => '1']);
                        return $this->sendResponse($user, 'Status Update successfully');
                    }
                } else {
                    return $this->sendError('Not Found.', ['error' => 'Record not found please check given id']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function moveToTrash(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $user = User::with(['code','country'])->find($id);
                if ($user) {
                    $user->delete();
                    // if ($user->move_to_trash == '1') {
                    
                    //     $user->update(['move_to_trash' => '0']);
                    //     return $this->sendResponse($user, 'Move to trash successfully');
                    // } else {
                    //     $user->update(['move_to_trash' => '1']);
                    //     return $this->sendResponse($user, 'Move to trash successfully');
                    // }
                } else {
                    return $this->sendError('Not Found.', ['error' => 'User not found']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id = null)
    {
        try {
            if ($request->isMethod('get')) {
                if (isset($id)) {
                    $id = $id;
                } else {
                    $id = auth()->user()->id;
                }

                $user = User::with(['code','country'])->find($id);
                if ($user) {

                    return $this->sendResponse($user, 'User record is');
                } else {
                    return $this->sendError('Not Found.', ['error' => 'User not found']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id = null)
    {
        try {

            if (($request->isMethod('put')) || ($request->isMethod('post'))) {

                if (isset($id)) {
                    $id = $id;
                } else {
                    $id = auth()->user()->id;
                }
                $user = User::find($id);

                $input = $request->all();

                if ($input['status'] == 1) {
                    $status = '1';
                } else {
                    $status = '0';
                }

                if ($user) {

                    $user->update([
                        'name' => isset($input['name']) ? $input['name'] : $user->name,
                        'email' => isset($input['email']) ? $input['email'] : $user->email,
                        'address' => isset($input['address']) ? $input['address'] : $user->address,
                        'phone' => isset($input['phone']) ? $input['phone'] : $user->phone,
                        'code' => isset($input['code']) ? $input['code'] : $user->code,
                        'state' => isset($input['state']) ? $input['state'] : $user->state,
                        'city' => isset($input['city']) ? $input['city'] : $user->city,
                        'zip' => isset($input['zip']) ? $input['zip'] : $user->zip,
                        'country' => isset($input['country']) ? $input['country'] : $user->country,
                        'status' =>  $status
                    ]);

                    return $this->sendResponse($user, 'Record update successfullly');
                } else {
                    return $this->sendError('Not Found.', ['error' => 'Record not found of the given id.']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }


    public function search(Request $request)
    {

        try {

            $query = User::where('move_to_trash', '=', '0')->where('id', '!=', 1);
            if (isset($request['status']) && $request['status'] != null) {

                $query->where('status', $request['status']);
            }
           
            if (isset($request['search']) && $request['search'] != null) {

                $query->where('phone', '=', $request['search']);
            }
            if (isset($request['search']) && $request['search'] != null) {

                $query->orWhere('name', 'LIKE', '%' . $request['search'] . '%');
            }
            if (isset($request['search']) && $request['search'] != null) {

                $query->orWhere('email', 'LIKE', '%' . $request['search'] . '%');
            }



            $user = $query->get();
            if ($user) {
                return $this->sendResponse($user, 'User List');
            } else {
                return $this->sendResponse($user, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }
    public function index()
    {

        try {
            $user = User::where('move_to_trash', '=', '0')->where('id', '!=', 1)->orderBy('id', 'desc')->get();
            if ($user) {
                return $this->sendResponse($user, 'User List');
            } else {
                return $this->sendResponse($user, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }

    public function usersListDropdown()
    {

        try {
            $user = User::where('move_to_trash', '=', '0')->where('id', '!=', 1)->orderBy('id', 'desc')->get();
            if ($user) {

                foreach ($user as $val) {
                    $temp['id'] = $val->id;
                    $temp['text'] = $val->name.' '.$val->last_name;
                    $res[] = $temp;
                }
                return $this->sendResponse($res, 'User List');
            } else {
                return $this->sendResponse($user, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
        }
    }

    public function getDevice()
    {

        $device = Device::select('id', 'name')->where('status', '=', 'active')->get();

        if ($device) {
            return $this->sendResponse($device, 'Device List');
        } else {
            return $this->sendResponse($device, 'No record found');
        }
    }

    public function changePass(Request $request, $id = null)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(['Status' =>
            false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
        }

        if (isset($id)) {
            $id = $id;
        } else {
            $id = auth()->user()->id;
        }
        $input = $request->all();

        $user = User::find($id);

        $input = $request->all();


        if ($user) {
            $user->update(['password' => bcrypt($input['password'])]);
            return $this->sendResponse($user, ' Password update successfully');
        } else {
            return $this->sendError($user, 'Password not update successfully');
        }
    }

    public function forgot_new(Request $request)
    {



        // Password::sendResetLink($credentials);
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }


    public function getLocation($ip)
    {
         
            $data = \Location::get($ip);
            return $this->sendResponse($data, ' Location is:');
            // return response()->json(["data" => $data]);
    }
}

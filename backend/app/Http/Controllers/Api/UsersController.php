<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class UsersController extends Controller
{
    
    public $successOutput = array(
        'status' => 'success',
        'message' => 'updated successfully',
        'custom' => ''
    );
    public $successOutputData = array(
        'status' => 'success',
        'message' => 'updated successfully',
        'data' => ''
    );
    public $errorOutput = array(
        'status' => 'error',
        'message' => 'Not updated successfully',
        'custom' => ''
    );
    public $paramMissings = array(
        'status' => 'error',
        'message' => 'params missing',
        'params' => ''
    );

    public function output($array = null)
    {
        echo json_encode($array);
        exit();
    }


     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {


       
        // try{
            // $validator = $this->validate($request, ['name' => 'required|min:3', 'email' => 'required|email|unique:users', 'password' => 'required|min:6', ]);
            // $errors = $validator->errors();

            
            $validator = Validator::make( $request->all(),[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users', 
                'password' => 'required|min:6'

            ]);
            

             if($validator->fails()){
                $this->errorOutput['code'] = 201;
                $this->errorOutput['message'] = $validator->errors()->first();
                $this->output($this->errorOutput);

             }
         
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Page not found'], 404);

        // }   
    }


     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try{
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;

                return $this->sendResponse($success, 'User login successfully.');
            }
            else
            {
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
        $response = ['success' => true, 'data' => $result, 'message' => $message, ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        try{
            $response = ['success' => false, 'message' => $error, ];

            if (!empty($errorMessages))
            {
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

        return $this->sendResponse($request->user() , 'User login successfully.');
    }


     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser(Request $request)
    {
      
        // try{
            if ($request->isMethod('post'))
            {

                $validator = Validator::make( $request->all(),[
                    'name' => 'required|min:3',
                    'email' => 'required|email|unique:users', 
                    'address' => 'required',
                    'phone'=>  'required'

                ]);
                

                 if($validator->fails()){
                    $this->errorOutput['code'] = 201;
                    $this->errorOutput['message'] = $validator->errors()->first();
                    $this->output($this->errorOutput);

                 }

                $input = $request->all();

                $input['password'] = bcrypt('welcome');
                $user = User::create($input);
                $success['name'] = $user->name;
                if ($user)
                {
                    $this->successOutputData['data'] = $user;
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


     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, $id)
    {
        try{
            if ($request->isMethod('put'))
            {

                $user = User::find($id);
                if ($user)
                {
                    if ($user->status == 1)
                    {

                        $user->update(['status' => '0']);
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $user->update(['status' => '1']);
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }

                }
                else
                {
                    $this->errorOutput['custom'] = "Status not update successfully.Please try again.";
                    $this->output($this->errorOutput);
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
        try{
            if ($request->isMethod('get'))
            {

                $user = User::find($id);

                if ($user)
                {
                    if ($user->move_to_trash == '1')
                    {

                        $user->update(['move_to_trash' => '0']);
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $user->update(['move_to_trash' => '1']);
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }

                }
                else
                {
                    $this->errorOutput['custom'] = "User not found";
                    $this->output($this->errorOutput);
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
    public function view(Request $request, $id)
    {
        try
        {
            if ($request->isMethod('get'))
            {

                $user = User::find($id);

                if ($user)
                {
                    $this->successOutputData['data'] = $user;
                    $this->output($this->successOutputData);
                }
                else
                {
                    $this->errorOutput['custom'] = "Record not found";
                    $this->output($this->errorOutput);
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


    public function update(Request $request, $id)
    {
        try{
                if ($request->isMethod('put'))
                {
                    $user = User::find($id);
                    $input = $request->all();

                    if ($user)
                    {
                        $user->update(['name' => $input['name'], 'email' => $input['email'], 'address' => $input['address'],'phone' => $input['phone'] ]);

                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $this->errorOutput['custom'] = "Record not update";
                        $this->output($this->errorOutput);
                    }

                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Page not found'], 404);

            }

    }
    public function index()
    {
        
      
               
                    $user = User::where('move_to_trash','=','0')->where('id','!=',1)->orderBy('id','desc')->get();
                 
                    
                    if ($user)
                    {
                  
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $this->errorOutput['custom'] = "Record not found";
                        $this->output($this->errorOutput);
                    }


                   
                
           

    }

    public function getDevice(){

        $device = Device::select('id','name')->get();
        if ($device)
        {
            $this->successOutputData['data'] = $device;
            $this->output($this->successOutputData);
        }
        else
        {
            $this->errorOutput['custom'] = "Record not found";
            $this->output($this->errorOutput);
        }

    }

    public function changePass(Request $request,$id){

        $validator = Validator::make( $request->all(),[
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',
           

        ]);
    
         if($validator->fails()){
            $this->errorOutput['code'] = 201;
            $this->errorOutput['message'] = $validator->errors()->first();
            $this->output($this->errorOutput);
         }

                  $input = $request->all();
                  $user = User::find($id);
                    $input = $request->all();
                  

                    if ($user)
                    {
                        $user->update(['password' => bcrypt($input['password'])]);
                        $this->successOutputData['data'] = $user;
                        $this->output($this->successOutputData);
                    }
                    else
                    {
                        $this->errorOutput['custom'] = "Record not update";
                        $this->output($this->errorOutput);
                    }



    }
}

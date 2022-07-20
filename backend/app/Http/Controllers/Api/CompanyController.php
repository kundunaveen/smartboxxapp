<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\CompanyRequest;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Mail;

class CompanyController extends Controller
{
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

    public function companyList(){
        
        try {
            $query = Company::latest();
        
            $data = $query->get();
            
                return $this->sendResponse($data, 'Company list');
            // } else {
            //     return $this->sendResponseError($data, 'Record not found');
            // }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occured'], 404);
        }
    }

    public function addCompany(CompanyRequest $request){
        // $var = $request->validated();
        // dd($var);
       try{

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:companies',
                'email' => 'required|email|unique:companies',
                'code' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'contact_firstname' => 'required',
                'contact_lastname' => 'required',
                'street' => 'required|min:8',
                'country' =>  'required',
                'state' =>  'required',
                'city' =>  'required',
                'zip' =>  'required',
            ]);

             if ($validator->fails()) {
                return response()->json(['Status' =>
                false, 'message' => $validator->errors()->first(), 'Data' => '', 'Status_code' => "401"]);
            }else{
                $input = $request->all();
                $input['password'] = bcrypt('welcome');
                $success = Company::create($input);
                if ($success) {
                    return $this->sendResponse($success, 'Company added sucessfully.');
                } else {
                    return $this->sendResponseError($success, 'Company not added. Please try again or contact admin.');
                }
            }

        }catch  (\Exception $e) {
            return response()->json(['error' => 'Error occured. Please contact site admin'], 404);
        }
    }

    public function deleteCompany(Request $request,$id){
         try {
            if ($request->isMethod('get')) {
                $company = Company::find($id);
                if ($company) {
                    $company->delete();
                    return $this->sendResponse('deleted', 'Company deleted sucessfully.');
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
    public function statusChange(Request $request, $id)
    {
        try {
            if ($request->isMethod('put')) {

                $user = Company::find($id);
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

    public function search(Request $request)
    {

        try {

            $query = Company::where('deleted_at', '=', '0');
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



            $company = $query->get();
            if ($company) {
                return $this->sendResponse($company, 'User List');
            } else {
                return $this->sendResponse($company, 'No record found');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthig is wrong.'], 404);
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

                $company = Company::find($id);
                if ($company) {

                    return $this->sendResponse($company, 'User record is');
                } else {
                    return $this->sendError('Not Found.', ['error' => 'User not found']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function changePass(Request $request, $id = null)
    {
        // dd($request->all());
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

        $user = Company::find($id);
        $input = $request->all();
        
        if($request->notify_email){

            $data = [
                'password'=>$input['password'],
                'email' => 'preetisingh1@virtualemployee.com',
                'subject' => 'Password Changed',
                'password'=>$request->password
            ];
            $success =  Mail::send('email.changepassword', $data, function ($message) use ($data) {
                        $message->to($data['email'])
                            ->subject($data['subject']);
                    });
        }

        if ($user) {
            $user->update(['password' => bcrypt($input['password'])]);
            return $this->sendResponse($user, ' Password update successfully');
        } else {
            return $this->sendError($user, 'Password not update successfully');
        }
    }

     public function update(Request $request, $id = null)
    {
        try {

            if (($request->isMethod('put')) || ($request->isMethod('post'))) {

                if (isset($id)) {
                    $id = $id;
                } else {
                    $id = auth()->user()->id;
                }
                $user = Company::find($id);

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
                        'street' => isset($input['street']) ? $input['street'] : $user->street,
                        'phone' => isset($input['phone']) ? $input['phone'] : $user->phone,
                        'code' => isset($input['code']) ? $input['code'] : $user->code,
                        'state' => isset($input['state']) ? $input['state'] : $user->state,
                        'city' => isset($input['city']) ? $input['city'] : $user->city,
                        'zip' => isset($input['zip']) ? $input['zip'] : $user->zip,
                        'country' => isset($input['country']) ? $input['country'] : $user->country,
                        'status' =>  $status,
                        'contact_firstname'=> isset($input['contact_firstname']) ? $input['contact_firstname'] : $user->contact_firstname,
                        'contact_lastname'=> isset($input['contact_lastname']) ? $input['contact_lastname'] : $user->contact_lastname,
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
}

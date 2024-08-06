<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Eastwest\Json\Facades\Json;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Throwable;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
/**
 * @group Users
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getUserById', 'updateUser', 'login','register', 'getUserByMobile','refresh', 'respondWithToken']]);
    }

    /**
     * User list
     *
     * This endpoint is used to get user list.
     *
     * 
     * @header Authorization Bearer {token}
     * 
     * @response scenario="User list" {
     * "user" :   [
     * {
     *   "_id": "65eec0aa4b28c694b60ec10c",
     *   "mobile": 3294839384,
     *   "name": null,
     *   "email": null,
     *   "image": null,
     *   "user_pincode": null,
     *       "longitude": -74.006
     *   "user_location": {
     *       "latitude": 40.7128,
     *   },
     *   "rera_number": 6767,
     *   "user_city": "una",
     *   "otp_status": true,
     *   "status": true,
     *   "updated_at": "2024-03-11T08:28:26.326000Z",
     *   "created_at": "2024-03-11T08:28:26.326000Z"
     *  },
     * ]
     *
     */
    // Get ser list
    public function User_list(Request $request)
    {
        try {
            $jsonData = $request->getContent();
            $requestData = json_decode($jsonData, true);
            
            // if ($requestData === null) {
            //     $users = DB::collection('users')->paginate(10);
            //     return response()->json([
            //         'message' => 'Request processed successfully',
            //         'users' => $users,
            //     ]);
            // }
            $keyword = $requestData['keyword'] ?? null;

            $filters = $requestData['filters'] ?? [];
            $page = $requestData['page'] ?? 1;
            $limit = $requestData['limit'] ?? 10;
    
            // $query = DB::collection('users')->with('ratings');
            // $query = User::query()->with('ratings');
            $query = User::query()
                ->where('role', 'user')
                ->with('ratings')
                ->orderBy('created_at', 'desc'); 

            // dd($query);

    
            foreach ($filters as $key => $value) {
                if (in_array($key, ['review', 'rating', 'rera_number', 'user_city','name'])) {
                    if ($key === 'review' || $key === 'rating' ) {
                        $query->where($key, $value);
                    } else {
                        $query->where($key, 'like', '%' . $value . '%');
                    }
                }
            }
    
            if ($keyword) {
                $keywords = explode(' ', $keyword);
            
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $term) {
                        print($term);
                        $query->where('user_city', 'REGEX', "/$term/i")->orWhere('name', 'REGEX', "/$term/i");
                    }
                });
            }
            
            
            $users = $query->paginate($limit, ['*'], 'page', $page);

            $totalUsersRated = 0;
            $totalRatings = 0;

            $totalUsersDisplayed = $users->count();

            foreach ($users as $user) {
                $userRatingsTotal = 0;
                $userRatingsCount = 0; 
                if ($user->ratings) {
                    $userRatingsCount = $user->ratings->count();
                    foreach ($user->ratings as $rating) {
                        $userRatingsTotal += $rating->rating;
                        $totalRatings += $rating->rating;
                    }
                }
                if ($userRatingsCount > 0) {
                    $user->average_user_rating = round($userRatingsTotal / $totalUsersDisplayed, 2);
                } else {
                    $user->average_user_rating = null;
                }
               foreach ($user->ratings as $rating) {
                $rating->updated_at = date('Y-m-d', strtotime($rating->updated_at));
                $rating->created_at = date('Y-m-d', strtotime($rating->created_at));
            }

                
                
                
                $totalUsersRated += $userRatingsCount;

                // dd($totalUsersRated += $totalUsersDisplayed);
            }
            
            
            
            return response()->json([
                'message' => 'Users listed successfully',
                'users' => $users,
                'limit' => $limit,
                'page' => $page,
                'total_pages' => $users->lastPage(),
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process request.', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh_auth_token()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'Bearer',
            ]
        ]);
    }



   /**
     * Login a user
     *
     * This endpoint is used to login a user.
     *
     * payload :  {
     *               "mobile": "3535534323",
     *               "otp_status": true,
     *               "status": true,
     *               "user_location": [
     *       {
     *           "coords": {
     *               "speed": -1,
     *               "longitude": 76.69112317715411,
     *               "latitude": 30.71134927265382,
     *               "accuracy": 16.965582688710988,
     *               "heading": -1,
     *               "altitude": 318.2151985168457,
     *               "altitudeAccuracy": 7.0764055252075195
     *           },
     *           "timestamp": 1709037095653.2131
     *       }
     *   ],
     *   
     *            }
     * 
     * @bodyParam mobile integer required digits:10 Example: 2093235874
     * @bodyParam otp_status boolean required Example: false
     * @bodyParam user_location array required 
     * @bodyParam status boolean required Example: true
     * 
     * @response scenario="success" 
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.      eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzEwMTQ1NzcyLCJleHAiOjE3MTAxNDkzNzIsIm5iZiI6MTcxMDE0NTc3MiwianRpIjoidm5kT1VrdEVRMzZaZHhBMCIsInN1YiI6IjY1ZWVjMGFhNGIyOGM2OTRiNjBlYzEwYyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.dMkpq1VJasyxRPZsLO6rc5dstN_n8oAMRgfOcffLIiw",
     * "token_type": "bearer",
     * "expires_in": 3600,
     * "user" :   {
     *   "_id": "65eec0aa4b28c694b60ec10c",
     *   "mobile": 3294839384,
     *   "name": null,
     *   "email": null,
     *   "image": null,
     *   "user_pincode": null,
     *       "longitude": -74.006
     *   "user_location": {
     *       "latitude": 40.7128,
     *   },
     *   "rera_number": 6767,
     *   "user_city": "una",
     *   "otp_status": true,
     *   "status": true,
     *   "updated_at": "2024-03-11T08:28:26.326000Z",
     *   "created_at": "2024-03-11T08:28:26.326000Z"
     *  },
     * }
     *
     * @response 401 scenario="Failed Login"{
     * "message": "Invalid login credentials"
     * }
     *
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'=>'required|integer|digits:10',
            'otp_status'=>'required|boolean',
            // 'name'=>'required|string',
            // 'user_pincode'=>'required|integer',
            // 'email'=>'required|email',
            // 'user_location'=>'required|array',
            // 'status'=>'required|boolean',
            // 'payment_res'=>'required|array',
            // 'payment_status'=>'required|integer',
    
        ]);
        $exists = User::where('mobile', $request->mobile)->exists();

        if ($exists) {
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }
            $user = User::where('mobile', $request->mobile)->first();
            if($request->otp_status === true){
                // if($request->payment_status === true){
                    $token = Auth::guard('api')->login($user);
                    return response()->json([
                        'message' => 'User logged in successfully',
                        'access_token' => $token,
                        'user' => $user,
                        'token_type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 365 * 24 * 60
                    ]);
            //     }else{
            //         return $response=[
            //             'success'=> false,
            //             'message'=> 'Payment not done',
            //         ];
            // }
                
            }else {
                return $response=[
                    'success'=> false,
                    'message'=> 'Invalid OTP',
                ];
            }
        }else {
            $validator2 = Validator::make($request->all(),[
                'mobile'=>'required|integer|digits:10',
                'otp_status'=>'required',
                'user_location'=>'required',
                // 'user_pincode' => 'nullable|integer|digits_between:1,6',
                'user_pincode' => 'nullable',
                'payment_res'=>'array',
                'payment_status'=>'required',
                'email'=>'email|nullable',
                'user_city'=>'required',
                'name'=> "nullable",
                'password'=> "nullable",
                'role'=> "nullable",
                'average_user_rating' => "nullable",
                'ratings' => 'nullable',
                'rera_number' => 'nullable',
                'image' => 'nullable',
                'notification_push_token' => 'nullable',
                'notification_data' => 'nullable'

            ]);
            $status = true;

            if($validator2->fails())
            {
                return response()->json($validator2->errors());
            }
            if($request->otp_status === true){
                if($request->user_location !== '' || $request->user_location !== null){
                        $role = $request->role ?? 'user';

                        $user = User::create([
                            'mobile'=>$request->mobile,
                            'otp_status'=>$request->otp_status,
                            'user_location'=>$request->user_location,
                            'user_city'=>$request->user_city,
                            'status'=>$request->status,
                            'email'=>$request->email,
                            'user_pincode'=>$request->user_pincode,
                            'role' => $role,
                            'payment_res'=>$request->payment_res,
                            'payment_status'=>$request->payment_status,
                            'name'=> $request->name ? $request->name : "N/A",
                            'password'=> $request->password ? $request->password : "N/A",
                            'image' => $request->image ? $request->image : "N/A",
                            'rera_number' => $request->rera_number ? $request->rera_number : "N/A",
                            'image' => $request->image ? $request->image : "N/A",
                            'notification_push_token' => $request->notification_push_token ? $request->notification_push_token : "N/A",
                            'notification_data' => $request->notification_data ? $request->notification_data : "N/A"

                        ]);
                        $token = Auth::guard('api')->login($user);
                        return response()->json([
                            'message' => 'User registered successfully',
                            'access_token' => $token,
                            'user' => $user,
                            'token_type' => 'Bearer',
                            'expires_in' => auth()->factory()->getTTL() * 365 * 24 * 60
                        ]);
                
                   
                }else{
                    return $response=[
                        'success'=> false,
                        'message'=> 'User location required',
                    ];
                }
            }else{
                return response()->json([
                    'error'=>'Invalid OTP',
                ]); 
            } 

        }
        
    }




    // public function login(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'mobile'=>'required|integer|digits:10',
    //         'otp_status'=>'required|boolean',
    //         // 'name'=>'required|string',
    //         // 'user_pincode'=>'required|integer',
    //         // 'email'=>'required|email',
    //         'user_location'=>'required|array',
    //         'status'=>'required|boolean',
    //         'payment_res'=>'required|array',
    //         'payment_status'=>'required|integer',

    //     ]);
    //     $exists = User::where('mobile', $request->mobile)->exists();

    //     if ($exists) {
    //         if ($validator->fails()) {
    //             return response()->json(['error' => $validator->errors()], 401);
    //         }
    //         $user = User::where('mobile', $request->mobile)->first();
    //         if($request->otp_status === true){
    //             if($request->payment_status === true){
    //                 $token = Auth::guard('api')->login($user);
    //                 return response()->json([
    //                     'message' => 'User logged in successfully',
    //                     'access_token' => $token,
    //                     'user' => $user,
    //                     'token_type' => 'Bearer',
    //                     'expires_in' => auth()->factory()->getTTL() * 24 * 60
    //                 ]);
    //             }else{
    //                 return $response=[
    //                     'success'=> false,
    //                     'message'=> 'Payment not done',
    //                 ];
    //         }
                
    //         }else {
    //             return $response=[
    //                 'success'=> false,
    //                 'message'=> 'Invalid OTP',
    //             ];
    //         }
    //     }else {
    //         $validator2 = Validator::make($request->all(),[
    //             'mobile'=>'required|integer|digits:10',
    //             'otp_status'=>'required',
    //             'user_location'=>'required',
    //             'name'=>'required|string',
    //             // 'user_pincode' => 'nullable|integer|digits_between:1,6',
    //             'user_pincode' => 'nullable',
    //             'payment_res'=>'required|array',
    //             'payment_status'=>'required|integer',
    //             'email'=>'email',
    //             'user_city'=>'required',

    //         ]);
    //         $status = true;

    //         if($validator2->fails())
    //         {
    //             return response()->json($validator2->errors());
    //         }
    //         if($request->otp_status === true){
    //             if($request->user_location !== '' || $request->user_location !== null){
    //                 if($request->payment_status === true){
    //                     $role = $request->role ?? 'user';

    //                     $user = User::create([
    //                         'mobile'=>$request->mobile,
    //                         'otp_status'=>$request->otp_status,
    //                         'user_location'=>$request->user_location,
    //                         'user_city'=>$request->user_city,
    //                         'status'=>$request->status,
    //                         'email'=>$request->email,
    //                         'user_pincode'=>$request->user_pincode,
    //                         'name'=>$request->name,
    //                         'payment_res'=>$request->payment_res,
    //                         'payment_status'=>$request->payment_status,
    //                         'role' => $role,
    //                     ]);
    //                     $token = Auth::guard('api')->login($user);
    //                     return response()->json([
    //                         'message' => 'User registered successfully',
    //                         'access_token' => $token,
    //                         'user' => $user,
    //                         'token_type' => 'Bearer',
    //                         'expires_in' => auth()->factory()->getTTL() * 24 * 60
    //                     ]);
    //                 }else{
    //                     return $response=[
    //                         'success'=> false,
    //                         'message'=> 'Payment not done',
    //                     ];
    //                 }
                   
    //             }else{
    //                 return $response=[
    //                     'success'=> false,
    //                     'message'=> 'User location required',
    //                 ];
    //             }
    //         }else{
    //             return response()->json([
    //                 'error'=>'Invalid OTP',
    //             ]); 
    //         } 

    //     }
        
    // }


    protected function respondWithToken($token, $user)
    {
        $expiresInMinutes = auth()->factory()->getTTL()* 365 * 24 * 60; // 24 hours * 60 minutes
    
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
            'expires_in' => $expiresInMinutes
        ]);
    }
    

    
   /**
     * Update a user
     *
     * This endpoint is used to update details of a specific user.
     * 
     * @header Authorization Bearer {token}
     * 
     * @urlParam _id required The ID of the user to update Example: 111
     * @bodyParam mobile integer required digits:10 Example: 2093235874
     * @bodyParam otp_status boolean required Example: false
     * @bodyParam user_location array required 
     * @bodyParam status integer required Example: true
     *
     * @response {
     *    "message": "User updated successfully"
     * }
     */
    // updateUser by id 


    public function updateUser(Request $request, $id)
        {
            // dd('Request Data: ', $request->all());
            // return response()->json($request->all()); 
            try {
                $validator = Validator::make($request->all(), [
                    'mobile'=>'integer|digits:10',
                    'otp_status'=>'',
                    'user_location'=>'array',
                    'user_pincode' => 'integer|digits_between:1,6',
                    'payment_res'=>'array',
                    'payment_status'=>'',
                    'email'=>'email',
                    'user_city'=>'',
                    'name'=> "",
                    'password'=> "",
                    'role'=> "",
                    'average_user_rating' => "",
                    'ratings' => '',
                    'rera_number' => '',
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'

                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()]);
                }
              
                $user = User::findOrFail($id);
                if(!$user){
                    return response()->json(['message' => 'User not found', 'user' => $user]);

                }else{
                    if ($request->hasFile('image')) {

                        $Uploadimage = $request->file('image');
                        $single_photo = time() . '_' . $Uploadimage->getClientOriginalName();
                        $Uploadimage->move(public_path('images/user_images'), $single_photo);
                        $photo = 'images/user_images/' . $single_photo;


                        $data = User::findOrFail($id);
                        $data->fill([         
                            'image' => $photo,
                            'otp_status' => $data->otp_status,
                            'mobile' => $data->mobile,
                            'payment_res' => $request->payment_res ? $request->payment_res : $data->payment_res,
                            'email' => $request->email ? $request->email : $data->email,
                            'user_city' => $request->user_city ? $request->user_city : $data->user_city,
                            'password' => $request->password ? $request->password : $data->password,
                            'name' => $request->name ? $request->name : $data->name,
                            'role' => $request->role ? $request->role : $data->role,
                            'average_user_rating' => $request->average_user_rating ? $request->average_user_rating : $data->average_user_rating,
                            'ratings' => $request->ratings ? $request->ratings : $data->ratings,
                            'rera_number' => $request->rera_number ? $request->rera_number : $data->rera_number,
                            'status' => $request->status ?? $data->status, 
                            'user_pincode' => $request->user_pincode ?? $data->user_pincode, 
                            'payment_status' =>  $request->payment_status ?? $data->payment_status, 

                        ]);
                        $data->save();          
                        return response()->json([
                            'message'=>'User updated successfully here',
                            'result'=> $data,
                            'request' => $request->all(),
                            
                        ]);

                    }
                    else{
                        $data = User::findOrFail($id);
                        $data->fill([         
                            'image' => $data->image,
                            'otp_status' => $data->otp_status,
                            'mobile' => $data->mobile,
                            'payment_res' => $request->payment_res,
                            'email' => $request->email,
                            'user_city' => $request->user_city,
                            'password' => $request->password,
                            'name' => $request->name,
                            'role' => $request->role,
                            'average_user_rating' => $request->average_user_rating,
                            'ratings' => $request->ratings,
                            'rera_number' => $request->rera_number,
                            'status' => $request->status, 
                            'user_pincode' => $request->user_pincode, 
                            'payment_status' => $request->payment_status, 
                            

                        ]);
                        $data->save();          
                        return response()->json([
                            'message'=>'User updated successfully with no image',
                            'result'=> $data,
                            "request" => $request->all()
                        ]);
                    }
                }              
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to update user.', 'error' => $e->getMessage()]);
            }
        }


    /**
     * Delete a user
     *
     * @header Authorization Bearer {token}
     * 
     * This endpoint is used to delete specific user.
     * 
     * @urlParam id required The ID of the user to delete. Example: 2
     *
     * @response {
     *    "message": "User deleted successfully"
     * }
     */
    // Delete user by id
    public function deleteUserById(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully.'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to delete user.', 'error' => $e->getMessage()], 500);
        }
    }



    /**
     * Get a specific user by entering mobile number
     * 
     * 
     * @header Authorization Bearer {token}
     * 
     * 
     * Get the details of a specific user.
     * 
     * @urlParam mobile required digits:10 The mobile number of the user. Example: 339430503535
     * 
     * "user" :   {
     *   "_id": "65eec0aa4b28c694b60ec10c",
     *   "mobile": 3294839384,
     *   "name": null,
     *   "email": null,
     *   "image": null,
     *   "user_pincode": null,
     *       "longitude": -74.006
     *   "user_location": {
     *       "latitude": 40.7128,
     *   },
     *   "rera_number": 6767,
     *   "user_city": "una",
     *   "otp_status": true,
     *   "status": true,
     *   "updated_at": "2024-03-11T08:28:26.326000Z",
     *   "created_at": "2024-03-11T08:28:26.326000Z"
     *  },
     * @response 404 {
     *   "message": "User not found"
     * }
     */
    // getUserByMobile
    public function getUserByMobile(Request $request, int $mobile)
    {
        try {
            $data = User::where('mobile', $mobile)->first();
            if (!$data) {
                return response()->json(['message' => 'User not found with this mobile number']);
            }

            return response()->json(['user' => $data], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve user.', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Get a specific user
     * 
     * 
     * @header Authorization Bearer {token}
     * 
     * 
     * Get the details of a specific user.
     * 
     * @urlParam id required The ID of the user. Example: 3
     * 
     * "user" :   {
     *   "_id": "65eec0aa4b28c694b60ec10c",
     *   "mobile": 3294839384,
     *   "name": null,
     *   "email": null,
     *   "image": null,
     *   "user_pincode": null,
     *       "longitude": -74.006
     *   "user_location": {
     *       "latitude": 40.7128,
     *   },
     *   "rera_number": 6767,
     *   "user_city": "una",
     *   "otp_status": true,
     *   "status": true,
     *   "updated_at": "2024-03-11T08:28:26.326000Z",
     *   "created_at": "2024-03-11T08:28:26.326000Z"
     *  },
     * @response 404 {
     *   "message": "User not found"
     * }
     */
    // getUserById
    public function getUserById(Request $request , $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found.']);
            }
            return response()->json(['user' => $user]);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve user.', 'error' => $e->getMessage()]);
        }
    }
  

}










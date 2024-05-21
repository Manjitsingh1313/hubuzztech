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
use App\Models\Commission;

/**
 * @group Users
 *
 * APIs for managing users
 */
class CommissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login','register', 'getUserByMobile','refresh', 'respondWithToken']]);
    // }


    public function AddCommission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'commission_with_user_id' => 'required',
            'property_id' => '',
            'amount' => 'required',
            'description' => '',
            'title' => '',
            'comm_date' => 'required',
            'status' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        // return "hh";
        $user = User::where('_id', $request->user_id)->first();
        $comm_with_user = User::where('_id', $request->commission_with_user_id)->first();
        // return $user;

            $commission = new Commission();
            $commission->user_id = $user;
            $commission->commission_with_user_id = $comm_with_user;
            $commission->property_id = $request->property_id;
            $commission->amount = $request->amount;
            $commission->description = $request->description;
            $commission->title = $request->title;
            $commission->comm_date = $request->comm_date;
            $commission->status = $request->status;
            $commission->save();
            return response()->json(['message' => 'Commission stored successfully', 'commission' => $commission]);
           
    }



    /**
     * Commission list
     *
     * This endpoint is used to get Commission list.
     *
     * 
     * @header Authorization Bearer {token}
     * 
     * @response scenario="Commission list" {
     * "commission_detail" :   [
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
    // Get Commission list
    public function Commission_list(Request $request)
    {
        try {
            $comm = Commission::all();
            
            return response()->json([
                'message' => 'Commission listed successfully',
                'data' => $comm
            ]);
    
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process request.', 'message' => $e->getMessage()]);
        }
    }
    
  
    /**
     * Update a commission
     *
     * This endpoint is used to update details of a specific commission.
     * 
     * @header Authorization Bearer {token}
     * 
     * @urlParam _id required The ID of the commission to update Example: 111
     * @bodyParam mobile integer required digits:10 Example: 2093235874
     * @bodyParam otp_status boolean required Example: false
     * @bodyParam user_location array required 
     * @bodyParam status integer required Example: true
     *
     * @response {
     *    "message": "User updated successfully"
     * }
     */
    // updateCommission by id 
    public function updateCommission(Request $request, $id)
        {
            try {
                $validator = Validator::make($request->all(), [
                    'user_id'=>'required',
                    'property_id'=>'',
                    'commission_with_user_id'=>'required',
                    'amount'=> "",
                    'description'=> "",
                    'title'=> "",
                    'comm_date' => "",
                    'status' => '',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()]);
                }
                else{
                    $user = Commission::where('_id', $id)->exists();
                    if(!$commission){
                        return response()->json(['message' => 'Commission details not found', 'commission' => $commission]);

                    }else{
                        $data = Commission::findOrFail($id);
                        $data->fill([         
                            'user_id' => $data->user_id,
                            'amount' => $request->amount,
                            'description' => $request->description,
                            'title' => $request->title,
                            'comm_date' => $request->comm_date,
                            'status' => $request->status,

                        ]);
                        $data->save();          
                        return response()->json([
                            'message'=>'Commision details updated successfully',
                            'result'=> $data
                        ]);
                        }
                  
                }
                
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to update user.', 'error' => $e->getMessage()]);
            }
        }


    /**
     * Delete a commission
     *
     * @header Authorization Bearer {token}
     * 
     * This endpoint is used to delete specific commission.
     * 
     * @urlParam id required The ID of the commission to delete. Example: 2
     *
     * @response {
     *    "message": "Commission deleted successfully"
     * }
     */
    // Delete Commission by id
    public function deleteCommissionById(Request $request, $id)
    {
        try {
            $commission = Commission::find($id);
            if (!$commission) {
                return response()->json(['message' => 'commission not found.']);
            }

            $commission->delete();

            return response()->json(['message' => 'Commission deleted successfully.']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to delete commission.', 'error' => $e->getMessage()]);
        }
    }



    /**
     * Get a specific commission by entering userID
     * 
     * 
     * @header Authorization Bearer {token}
     * 
     * 
     * Get the details of a specific commission.
     * 
     * @urlParam user_id required The userID of the commission. Example: 339430503535
     * 
     * "commission" :   {
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
     *   "message": "Commission not found"
     * }
     */
    // getCommissionByUserID
    public function getCommissionByUserID(Request $request, int $user_id)
    {
        try {
            $data = Commission::where('user_id', $user_id)->first();
            if (!$data) {
                return response()->json(['message' => 'Commission Details not found with this UserID']);
            }

            return response()->json(['user' => $data], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve user.', 'error' => $e->getMessage()]);
        }
    }


}










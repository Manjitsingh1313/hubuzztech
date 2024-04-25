<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DealersController extends Controller
{
    /**
     * Display a listing of the dealers.
     *
     * @return \Illuminate\View\View
     */
    public function dealers()
    {
        $users = User::where('role', '!=', 'admin')
                 ->orderBy('created_at', 'desc')
                 ->get(); // You can also use User::where('role', 'dealer')->get(); if you want to filter by role
        // Pass user data to the view
        return view('dealer.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new dealer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dealer.create');
    }

    /**
     * Store a newly created dealer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function save(Request $request)
     {
         try {
             $validator = Validator::make($request->all(), [
                 'name' => 'required|string|max:255',
                 'email' => 'nullable|email|unique:users,email',
                 'user_pincode' => 'nullable|integer|max:999999',
                 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5242880',
                 'mobile' => 'required|integer|unique:users,mobile|digits:10',
                 'password' => 'required|string|min:6',
                //  'otp_status' => 'nullable|boolean',
                //  'status' => 'nullable|boolean',
                 'role' => 'required|string|in:admin,user',
             ]);
     
             if ($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
             }
     
             $validatedData = $validator->validated();
     
             // Sanitize and validate otp_status and status
                    // Set default values
                $validatedData['otp_status'] = true;
                $validatedData['status'] = true;
     
             $validatedData['mobile'] = intval(filter_var($validatedData['mobile'], FILTER_SANITIZE_NUMBER_INT));
             $validatedData['email'] = filter_var($validatedData['email'], FILTER_SANITIZE_EMAIL);
             $validatedData['name'] = filter_var($validatedData['name'], FILTER_SANITIZE_STRING);
             $validatedData['user_city'] = filter_var($request->user_city, FILTER_SANITIZE_STRING) ?? null;
             $validatedData['user_pincode'] = intval(filter_var($request->user_pincode, FILTER_SANITIZE_NUMBER_INT)) ?? null;
             $validatedData['rera_number'] = filter_var($request->rera_number, FILTER_SANITIZE_STRING) ?? null;
             $validatedData['password'] = Hash::make($request->password);
     
             // Create a new user
             User::create($validatedData);
     
             return redirect()->route('dealers')->with('success', 'Dealer created successfully');
         } catch (\Exception $e) {
             return redirect()->back()->withErrors(['error' => 'Failed to create dealer: ' . $e->getMessage()])->withInput();
         }
     }
     
     

     
     
     
    

    /**
     * Show the form for editing the specified dealer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $dealer = User::findOrFail($id);
        
        return view('dealer.edit', ['dealer' => $dealer]);
    }
    

    /**
     * Update the specified dealer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

     public function updateDealer(Request $request, $id)
     {
         try {
             $rules = [
                 'name' => 'nullable|string|max:255',
                 'mobile' => 'required|integer|unique:users,mobile|digits:10',
                 'email' => 'nullable|email|unique:dealers,email,' . $id,
                 'user_city' => 'nullable|string|max:255',
                 'user_pincode' => 'nullable|integer|max:999999',
                 'rera_number' => 'nullable|string|max:255',
                 'status' => 'nullable|boolean',
                 'role' => 'nullable|string|in:admin,user',
                 'password' => 'nullable|string|min:6',
                 'otp_status' => 'nullable|boolean',
                 'payment_res' => 'nullable|string|max:255',
                 'payment_status' => 'nullable|string|in:pending,completed,failed',
             ];
     
             $validator = Validator::make($request->all(), $rules);
             
             if ($validator->fails()) {
                 // If validation fails, return back with errors
                 return redirect()->back()
                     ->withErrors($validator)
                     ->withInput();
             }
     
             $dealer = User::find($id);
     
             if (!$dealer) {
                 return response()->json(['message' => 'Dealer not found'], 404);
             }
     
             $dealer->mobile = intval($request->mobile);
             $dealer->name = filter_var($request->name, FILTER_SANITIZE_STRING) ?? $dealer->name;
             $dealer->email = filter_var($request->email, FILTER_SANITIZE_EMAIL) ?? $dealer->email;
             $dealer->user_city = filter_var($request->user_city, FILTER_SANITIZE_STRING) ?? $dealer->user_city;
             $dealer->role = filter_var($request->role, FILTER_SANITIZE_STRING) ?? $dealer->role;
             $dealer->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN) ?? $dealer->status;
             $dealer->user_pincode = intval($request->user_pincode);
             $dealer->rera_number = filter_var($request->rera_number, FILTER_SANITIZE_STRING) ?? $dealer->rera_number;
             $dealer->password = $request->password ? Hash::make($request->password) : $dealer->password;
             $dealer->otp_status = filter_var($request->otp_status, FILTER_VALIDATE_BOOLEAN) ?? $dealer->otp_status;
             $dealer->payment_res = filter_var($request->payment_res, FILTER_SANITIZE_STRING) ?? $dealer->payment_res;
             $dealer->payment_status = filter_var($request->payment_status, FILTER_SANITIZE_STRING) ?? $dealer->payment_status;
     
             if ($request->hasFile('image')) {
                 $Uploadimage = $request->file('image');
                 $single_photo = time() . '_' . $Uploadimage->hashName(); 
                 if (!empty($dealer->image)) {
                     $oldImagePath = public_path('images/user_images/' . $dealer->image);
                     if (file_exists($oldImagePath)) {
                         unlink($oldImagePath);
                     }
                 }
                 $Uploadimage->move(public_path('images/user_images'), $single_photo); 
                 $dealer->image = $single_photo; 
             }
             $dealer->save();
     
             return redirect()->route('dealers')->with('success', 'Dealer updated successfully.');
     
         } catch (\Exception $e) {
             return redirect()->back()
                 ->withErrors(['error' => 'Failed to update dealer: ' . $e->getMessage()])
                 ->withInput();
         }
     }
     

    
    
    
    

    

    

    /**
     * Remove the specified dealer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
{
    try {
        $dealer = User::findOrFail($id);

        // if ($dealer->role === 'admin') {
        //     return redirect()->route('dealers')
        //         ->withErrors(['error' => 'This user is an admin. Are you sure you want to delete?'])
        //         ->with('adminDeleteConfirmation', true);
        // }

        $dealer->delete();

        return redirect()->route('dealers')->with('success', 'Dealer deleted successfully');
    } catch (\Exception $e) {
        return redirect()->route('dealers')->withErrors(['error' => 'Failed to delete dealer: ' . $e->getMessage()]);
    }
}

    
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function SendNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => '',
            'desctiption' => '',
            'sender_id' => '',
            'receiver_id' => '',
            'receiver_token' => '',
            'sender_token' => '',
            'attachment' => '',
            'message' => '',
            'notification_date' => '',
            'status' => '',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        // return "hh";
        $notifiSender = User::where('_id', $request->sender_id)->first();
        $notifiReceiver = User::where('_id', $request->receiver_id)->first();

        if ($notifiSender && $notifiReceiver) {
            $notification = new Notification();
            $notification->sender_id = $notifiSender->toArray();
            $notification->receiver_id = $notifiReceiver->toArray();
            $notification->desctiption = $request->desctiption;
            $notification->receiver_token = $request->receiver_token;
            $notification->sender_token = $request->sender_token;
            $notification->attachment = $request->attachment;
            $notification->message = $request->message;
            $notification->title = $request->title;
            $notification->notification_date = $request->notification_date;
            $notification->status = $request->status;
            $notification->save();
            return response()->json(['message' => 'Notification stored successfully', 'notification' => $notification]);
        } else {
            if (!$notifiSender) {
                return response()->json(['error' => 'Sender not found'], 404);
            }
        
            if (!$notifiReceiver) {
                return response()->json(['error' => 'Receiver not found'], 404);
            }
        }
      
           
    }


    public function Notification_list(Request $request, $sender_id)
    {
        try {
            $notifications = Notification::where('sender_id', $sender_id)->get();
            
            return response()->json([
                'message' => 'Notification listed successfully',
                'data' => $notifi
            ]);
    
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process request.', 'message' => $e->getMessage()]);
        }
    }

    public function updateNotification(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => '',
                'desctiption' => '',
                'sender_id' => '',
                'receiver_id' => '',
                'receiver_token' => '',
                'sender_token' => '',
                'attachment' => '',
                'message' => '',
                'notification_date' => '',
                'status' => '',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()]);
            }
            else{
                $user = Notification::where('_id', $id)->exists();
                if(!$notifi){
                    return response()->json(['message' => 'Notification details not found', 'data' => $notifi]);

                }else{
                    $data = Notification::findOrFail($id);
                    $data->fill([         
                        'title' => $data->title,
                        'desctiption' => $request->desctiption,
                        'sender_id' => $request->sender_id,
                        'receiver_id' => $request->receiver_id,
                        'receiver_token' => $request->receiver_token,
                        'sender_token' => $request->sender_token,
                        'attachment' => $request->attachment,
                        'message' => $request->message,
                        'notification_date' => $request->notification_date,
                        'status' => $request->status,

                    ]);
                    $data->save();          
                    return response()->json([
                        'message'=>'Notification details updated successfully',
                        'result'=> $data
                    ]);
                    }
              
            }
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update user.', 'error' => $e->getMessage()]);
        }
    }

    public function deleteNotificationById(Request $request, $id)
    {
        try {
            $notifi = Notification::find($id);
            if (!$notifi) {
                return response()->json(['message' => 'Notification not found.']);
            }
            $notifi->delete();

            return response()->json(['message' => 'Notification deleted successfully.']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to delete Notification.', 'error' => $e->getMessage()]);
        }
    }

    


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * @group Chats
 *
 * APIs for managing chats
 */
class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
        // public function sendMessage(Request $request)
        // {
        //     try {
        //         $validator = Validator::make($request->all(), [
        //             'sender' => 'required|string',
        //             'recipient' => 'required|string',
        //             'messages' => 'required|array',
        //             'messages.*.msg' => 'required',
        //             'messages.*.currentTime' => 'nullable|string',
        //         ]);
        
        //         if ($validator->fails()) {
        //             return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 400);
        //         }
        
        //         $sender = $request->input('sender');
        //         $recipient = $request->input('recipient');
        //         $messages = $request->input('messages');
        
        //         if (!User::where('_id', $sender)->exists()) {
        //             return response()->json(['message' => 'Sender does not exist'], 400);
        //         } elseif (!User::where('_id', $recipient)->exists()) {
        //             return response()->json(['message' => 'Recipient does not exist'], 400);
        //         }
                
        
        //         foreach ($messages as $message) {
        //             $chat = new Chat();
        //             $chat->sender_id = $sender;
        //             $chat->recipient_id = $recipient;
        //             $chat->message = $message['msg']; 
        //             $chat->created_at = now();
        //             // $chat->message_id = Str::uuid();
        //             // print($chat);
        //             $chat->save();
        //         }

                
        
        //         return response()->json(['message' => 'Messages sent successfully'], 200);
        //     } catch (\Exception $e) {
        //         return response()->json(['message' => 'Failed to send messages', 'error' => $e->getMessage()], 500);
        //     }
        // }
    
        // public function sendMessage(Request $request)
        // {
        //     try {
        //         $validator = Validator::make($request->all(), [
        //             'sender' => 'required|string',
        //             'recipient' => 'required|string',
        //             'messages' => 'required|array',
        //             'messages.*.msg' => 'required',
        //             'messages.*.currentTime' => 'nullable|string',
        //         ]);
        
        //         if ($validator->fails()) {
        //             return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 400);
        //         }
        
        //         $sender = $request->input('sender');
        //         $recipient = $request->input('recipient');
        //         $messages = $request->input('messages');
        
        //         if (!User::where('_id', $sender)->exists()) {
        //             return response()->json(['message' => 'Sender does not exist'], 400);
        //         } elseif (!User::where('_id', $recipient)->exists()) {
        //             return response()->json(['message' => 'Recipient does not exist'], 400);
        //         }
        
        //         // Create an associative array to hold messages grouped by sender and recipient pairs
        //         $groupedMessages = [];
        
        //         foreach ($messages as $message) {
        //             // Generate a unique key for each sender-recipient pair
        //             $key = $sender . '_' . $recipient;
        
        //             // Check if the key exists in the groupedMessages array
        //             if (!isset($groupedMessages[$key])) {
        //                 // If the key doesn't exist, create a new array for that sender-recipient pair
        //                 $groupedMessages[$key] = [];
        //             }
        
        //             // Append the message to the array corresponding to the sender-recipient pair
        //             $groupedMessages[$key][] = $message['msg'];
        //         }
        
        //         // Loop through the grouped messages and save them
        //         foreach ($groupedMessages as $key => $messages) {
        //             // Split the key back into sender and recipient IDs
        //             [$sender, $recipient] = explode('_', $key);
        
        //             // Create a new Chat object to save the grouped messages
        //             $chat = new Chat();
        //             $chat->sender_id = $sender;
        //             $chat->recipient_id = $recipient;
        //             $chat->messages = $messages; // Store messages as an array
        //             $chat->created_at = now();
        //             $chat->save();
        //         }
        
        //         return response()->json(['message' => 'Messages sent successfully'], 200);
        //     } catch (\Exception $e) {
        //         return response()->json(['message' => 'Failed to send messages', 'error' => $e->getMessage()], 500);
        //     }
        // }



    public function sendMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sender_id' => 'required|string|exists:users,_id',
                'recipient_id' => 'required|string|exists:users,_id',
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()]);
            }
            else{
                $sender_id = $request->input('sender_id'); 
                $recipient_id = $request->input('recipient_id'); 
                $sender_profile = User::find($sender_id);
                if (!$sender_profile) {
                    return response()->json(['message' => 'Sender not found.']);
                }
                $recipient_profile = User::find($recipient_id);
                if (!$recipient_profile) {
                    return response()->json(['message' => 'Recipient not found.']);
                }
                $chat = new Chat();
                $chat->sender_data = $sender_profile->toArray();
                $chat->recipient_data = $recipient_profile->toArray();
                $chat->sender_id = $sender_id;
                $chat->recipient_id = $recipient_id;
                $chat->message = $request->input('message');
                $chat->sent_at = now();
                $chat->save();
                return response()->json([
                    'message' => 'Message sent successfully',
                    'sent_message' => $chat,
                    'recipient_profile' => $recipient_profile,
                    'sender_profile' => $sender_profile,
                ]);
            }
          
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send message', 'error' => $e->getMessage()]);
        }
    }

        
    

    // public function getChat(Request $request, $recipient_id)
    // {

    //     try {
            
    //         if (!Auth::check()) {
    //             return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
    //         }
    //         if (!$recipient_id) {
    //             return response()->json(['message' => 'Recipient ID is missing.'], 400);
    //         }

    //         $sender_id = Auth::id();


    //         $chatExists = Chat::where(function ($query) use ($sender_id, $recipient_id) {
    //             $query->where('sender_id', $sender_id)
    //                 ->where('recipient_id', $recipient_id);
    //         })->orWhere(function ($query) use ($sender_id, $recipient_id) {
    //             $query->where('sender_id', $recipient_id)
    //                 ->where('recipient_id', $sender_id);
    //         })->exists();

    //         if (!$chatExists) {
    //             return response()->json(['message' => 'No chat messages found between the sender and recipient'], 404);
    //         }
    //         $chats = Chat::where(function ($query) use ($sender_id, $recipient_id) {
    //                     $query->where('sender_id', $sender_id)
    //                         ->where('recipient_id', $recipient_id);
    //                 })->orWhere(function ($query) use ($sender_id, $recipient_id) {
    //                     $query->where('sender_id', $recipient_id)
    //                         ->where('recipient_id', $sender_id);
    //                 })->get();

    //         $senderMessages = [];
    //         $recipientMessages = [];

    //         foreach ($messages as $message) {
    //             $formattedMessage = [
    //                 'date' => $message->created_at->format('d/m/Y H:i'),
    //                 'message' => $message->message
    //             ];

    //             if ($message->sender_id == $sender_id) {
    //                 $recipientMessages[] = $formattedMessage;
    //             } else {
    //                 $senderMessages[] = $formattedMessage;
    //             }
    //         }
    //         $sender_profile = User::find($sender_id);
    //         if (!$sender_profile) {
    //             return response()->json(['message' => 'Sender not found.'], 404);
    //         }

    //         $recipient_profile = User::find($recipient_id);
    //         if (!$recipient_profile) {
    //             return response()->json(['message' => 'Recipient not found.'], 404);
    //         }


    //         return response()->json([
    //             'sender_profile' => $sender_profile,
    //             'recipient_profile' => $recipient_profile,
    //             'sender_msgs' => $senderMessages,
    //             'recipient_msgs' => $recipientMessages
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()], 500);
    //     }
    // }




        
    // public function getChat(Request $request)
    // {
    //     $sender_id = $request->input('sender_id'); 
    //     $recipient_id = $request->input('recipient_id'); 
    //     // return $sender_id;
    //     // return $recipient_id;

    //     try {
    //         if (!$recipient_id) {
    //             return response()->json(['message' => 'Recipient ID is missing.']);
    //         }
    //         $chatExists = Chat::where('sender_id', $sender_id)
    //         ->where('recipient_id', $recipient_id)
    //         ->first();

    //         if (!$chatExists) {
    //             return response()->json(['message' => 'No chat messages found between the sender and recipient']);
    //         }
    //         else{
    //             $chatExists = Chat::where('sender_id', $sender_id)
    //             ->where('recipient_id', $recipient_id)
    //             ->get();
    //             $sender_profile = User::find($sender_id);
    //             if (!$sender_profile) {
    //                 return response()->json(['message' => 'Sender not found.']);
    //             }
    
    //             $recipient_profile = User::find($recipient_id);
    //             if (!$recipient_profile) {
    //                 return response()->json(['message' => 'Recipient not found.']);
    //             }
    
    //             return response()->json([
    //                 'chatDataLength' => count($chatExists),

    //                 'sender_profile' => $sender_profile,
    //                 'recipient_profile' => $recipient_profile,
    //                 'chatuserlist' => $chatExists,
    //             ]);
    //         }

           
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()]);
    //     }
    // }



    public function getChat(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized. Please log in.']);
            }
            $validator = Validator::make($request->all(), [
                'recipient_id' => 'required|string|exists:users,_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()]);
            }

            $user = Auth::id();
            $sender_id = $user;
            $recipient_id = $request->input('recipient_id');
            $chatExists = Chat::where(function ($query) use ($sender_id, $recipient_id) {
                $query->where('sender_id', $sender_id)
                    ->where('recipient_id', $recipient_id);
            })
            ->orWhere(function ($query) use ($sender_id, $recipient_id) {
                $query->where('sender_id', $recipient_id)
                    ->where('recipient_id', $sender_id);
            })
            ->exists();

            if (!$chatExists) {
                return response()->json(['message' => 'No chat messages found between the sender and recipient']);
            }

            $messages = Chat::where(function ($query) use ($sender_id, $recipient_id) {
                $query->where('sender_id', $sender_id)
                    ->where('recipient_id', $recipient_id);
            })
            ->orWhere(function ($query) use ($sender_id, $recipient_id) {
                $query->where('sender_id', $recipient_id)
                    ->where('recipient_id', $sender_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

            $senderMessages = [];
            $recipientMessages = [];

            foreach ($messages as $message) {
                $formattedMessage = [
                    'date' => $message->created_at->format('d/m/Y H:i'),
                    'message' => $message->message
                ];

                if ($message->sender_id == $sender_id) {
                    $recipientMessages[] = $formattedMessage;
                } else {
                    $senderMessages[] = $formattedMessage;
                }
            }

            return response()->json([
                'sender_id' => $sender_id,
                'recipient_id' => $recipient_id,
                'sender_msgs' => $senderMessages,
                'recipient_msgs' => $recipientMessages
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()]);
        }
    }

          
    public function getAuthChatList(Request $request)
    {
        $sender_id = $request->input('sender_id'); 
        // return $sender_id;

        try {
            
            if (!$sender_id) {
                return response()->json(['message' => 'sender ID is missing.']);
            }

            $chatExists = Chat::where('sender_id', $sender_id)
            ->first();

            if (!$chatExists) {
                return response()->json(['message' => 'No chat messages found']);
            }
            else{
                $sender_profile = User::find($sender_id);
                if (!$sender_profile) {
                    return response()->json(['message' => 'Sender not found.']);
                }
                $chatData = Chat::where('sender_id', $sender_id)
                ->get();
    
                return response()->json([
                    'chatDataLength' => count($chatData),
                    'sender_profile' => $sender_profile,
                    'authChatList' => $chatData,
                ]);
            }
           
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()]);
        }
    }

        
}
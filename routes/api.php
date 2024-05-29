<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ImageController;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;
use Dedoc\Scramble\Facades\Generator;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\NotificationController;





Route::group([
    'middleware' => 'api',
], function ($router) {

    // Users
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);
    Route::get('/user/{_id}', [UserController::class, 'getUserById']);
    Route::get('/user/mobile/{mobile}', [UserController::class, 'getUserByMobile']);
    Route::put('/user/{_id}', [UserController::class, 'updateUser']);
    Route::delete('/user/{_id}', [UserController::class, 'deleteUserById']);
    Route::get('/users', [UserController::class, 'User_list']);

    // Properties
    Route::get('/properties', [PropertyController::class, 'property_list']);
    Route::get('/getproperties/{id}',  [PropertyController::class, 'getPropertiesByUserId']);
    Route::post('/property/add', [PropertyController::class, 'storeProperty']);
    Route::put('/property/{_id}', [PropertyController::class, 'updateProperty']);
    Route::delete('/property/{_id}', [PropertyController::class, 'deletePropertyById']);
    Route::get('/my/properties/{id}', [PropertyController::class, 'My_Property_list']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'Payment_list']);
    Route::post('/make/payment', [PaymentController::class, 'MakePayment']);
    Route::get('/payment/{user_id}', [PaymentController::class, 'getPaymentsByUserID']);
    Route::get('/payment/{_id}', [PaymentController::class, 'getPaymentById']);
    Route::put('/payment/{_id}', [PaymentController::class, 'updatePayment']);
    Route::delete('/payment/{_id}', [PaymentController::class, 'deletePaymentById']);

    //chat
    Route::post('/chat', [ChatController::class, 'sendMessage']);
    Route::post('/chat/messages/{id}', [ChatController::class, 'getChat']);

    // rating
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::get('/ratings/total', [RatingController::class, 'getUserRatings']);

    // review
    Route::post('/reviews', [ReviewController::class, 'storeReview']);
    Route::put('reviews/{id}', [ReviewController::class, 'updateReview']);
    Route::delete('reviews/{id}', [ReviewController::class, 'deleteReview']);

    // commission
    Route::post('add/commission', [CommissionController::class, 'AddCommission']);
    Route::put('update/commission/{id}', [CommissionController::class, 'updateCommission']);
    Route::delete('delete/commission/{id}', [CommissionController::class, 'deleteCommission']);
    Route::get('/commission/list', [CommissionController::class, 'Commission_list']);
   
    // notification
    Route::post('send/notification', [NotificationController::class, 'SendNotification']);
    Route::put('update/notification/{id}', [NotificationController::class, 'updateNotification']);
    Route::delete('delete/notification/{id}', [NotificationController::class, 'deleteNotificationById']);
    Route::get('/notification/list/sender/{id}', [NotificationController::class, 'Notification_list_Sender']);
    Route::get('/notification/list/receiver/{id}', [NotificationController::class, 'Notification_list_Receiver']);


});



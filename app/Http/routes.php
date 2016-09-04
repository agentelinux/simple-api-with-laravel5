<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


$api = app('Dingo\Api\Routing\Router');

// Add this route for checkout or submit form to pass the item into paypal
Route::get('payment', array(
    'as' => 'payment',
    'uses' => 'PaypalController@createPayment',
));
// this is after make the payment, PayPal redirect back to your site
Route::get('payment/success', array(
    'as' => 'payment.status',
    'uses' => 'PaypalController@getPaymentStatus',
));


$api->version('v1', function ($api) {


    $api->get('hello', 'App\Http\Controllers\Api\HomeController@index');

    $api->post('register', 'App\Http\Controllers\Auth\ApiAuthController@register');

    $api->post('login', 'App\Http\Controllers\Auth\ApiAuthController@authenticate');

    $api->post('logout', 'App\Http\Controllers\Auth\ApiAuthController@logout');


    /*
     * Protected API route with JWT (must be logged in) throttle:60,1
     */
    $api->group(['middleware' => 'api.throttle', 'plan1'], function ($api) {

        $api->get('authenticated', 'App\Http\Controllers\Api\UsersController@authenticated');

        $api->get('token', 'App\Http\Controllers\Api\UsersController@refreshToken');

    });


});



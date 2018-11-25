<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// api routes



//
Route::group([
    'middleware' => ['api', 'cors'],
    'prefix' => 'api'], function(){

        Route::group([
            'prefix' => 'users'], function(){
                // users routes
                Route::match(['get','post'], '/', 'Api\users@list');
                Route::match(['get','post'], '/add', 'Api\users@add');
                Route::match(['get','post'], '/update', 'Api\users@update');
                Route::match(['get','post'], '/login', 'Api\users@login');
                Route::match(['get','post'], '/resetpassword', 'Api\users@resetPassword');
                Route::match(['get','post'], '/test', 'Api\users@test');
                Route::match(['get','post'], '/editprofileimage', 'Api\users@update_profile_image');
                Route::match(['get','post'], '/reg', 'Api\users@reg');
            });

    //categories routes
    Route::match(['get','post'], '/categories', 'Api\categories@categories');




    // subcategories routes
    Route::match(['get','post'], '/subcategories', 'Api\subcategories@subcategories');
    Route::match(['get','post'], '/mysubcategories', 'Api\subcategories@mysubcategories');
    Route::match(['get','post'], '/addsubcategory', 'Api\subcategories@add');
    Route::match(['get','post'], '/additem', 'Api\subcategories@additem');
    Route::group([
        'prefix' => 'subcategory'], function(){
            Route::match(['get','post'], '/block', 'Api\subcategories@block');
            Route::match(['get','post'], '/delete', 'Api\subcategories@delete');
            Route::match(['get','post'], '/active', 'Api\subcategories@active');
            Route::match(['get','post'], '/update', 'Api\subcategories@update');
        });


    Route::group([
            'prefix' => 'item'], function(){
                Route::match(['get','post'], '/block', 'Api\subcategories@blockitem');
                Route::match(['get','post'], '/delete', 'Api\subcategories@deleteitem');
                Route::match(['get','post'], '/active', 'Api\subcategories@activeitem');
                Route::match(['get','post'], '/update', 'Api\subcategories@updateitem');
            });







    // items routes
    Route::match(['get','post'], '/items', 'Api\subcategories@get_subcategory_details');


    // orders routes
    Route::match(['get','post'], '/neworder', 'Api\orders@new');
    Route::match(['get','post'], '/myorder', 'Api\orders@myorder');
    Route::match(['get','post'], '/requests', 'Api\orders@requests');
    Route::match(['get','post'], '/changeorderstatus', 'Api\orders@chanage_status');
});
//Route::match(['get','post'], '/api/users', 'Api\ApiController@index');



















// admin panel 

// 'middleware' => ['api', 'adminLogin'],
// 'middleware' => ['api', 'adminNotLogin'],
Route::group([
    'prefix' => 'admin'], function(){
       

            // logout route
            Route::match(['get','post'], '/logout', 'BackEnd\adminController@logout');

            // not logged pages 
          //  Route::group(['middleware' => 'adminNotLogin'], function(){
    
                Route::match(['get','post'], '/', 'BackEnd\adminController@login');
                Route::match(['get','post'], '/login', 'BackEnd\adminController@login');
           // });  



            // only logged pages 

          //  Route::group(['middleware' => 'adminLogin'], function(){
    
                Route::match(['get','post'], '/dashboard', 'BackEnd\adminController@dashboard');


                // categories 
                Route::match(['get','post'], '/categories', 'BackEnd\categories@index');
                Route::match(['get','post'], '/category/add', 'BackEnd\categories@add');
                Route::match(['get','post'], '/category/delete/{category_id}', 'BackEnd\categories@delete');
                Route::match(['get','post'], '/category/active/{category_id}', 'BackEnd\categories@active');
                Route::match(['get','post'], '/category/block/{category_id}', 'BackEnd\categories@block');
                Route::match(['get','post'], '/category/edit/{category_id}', 'BackEnd\categories@edit');



                // subcategory 
                Route::match(['get','post'], '/subcategories/{category_id}', 'BackEnd\subcategories@index');

                Route::group(['prefix' => 'subcategory'], function(){

                        // subcategories 
                    Route::match(['get','post'], '/delete/{category_id}/{subcategory_id}', 'BackEnd\subcategories@delete');
                    Route::match(['get','post'], '/active/{category_id}/{subcategory_id}', 'BackEnd\subcategories@active');
                    Route::match(['get','post'], '/block/{category_id}/{subcategory_id}', 'BackEnd\subcategories@block');
                    Route::match(['get','post'], '/edit/{category_id}/{subcategory_id}', 'BackEnd\subcategories@edit');
                });


                // items
                // customers 
                Route::match(['get','post'], '/items', 'BackEnd\users@customers');
                Route::group([
                    'prefix' => 'customer'], function(){

                        Route::match(['get','post'], '/{subcategory_id}', 'BackEnd\subcategories@items');
                        /*Route::match(['get','post'], '/block/{customer_id}', 'BackEnd\users@block');
                        Route::match(['get','post'], '/active/{customer_id}', 'BackEnd\users@active');
                        Route::match(['get','post'], '/edit/{customer_id}', 'BackEnd\users@edit');
                        Route::match(['get','post'], '/profile/{customer_id}', 'BackEnd\users@profile');*/
                    });



                    //m items
                    Route::group([
                        'prefix' => 'items'], function(){
    
                            Route::match(['get','post'], '/{category_id}/{subcategory_id}', 'BackEnd\items@index');
                            /*Route::match(['get','post'], '/block/{customer_id}', 'BackEnd\users@block');
                            Route::match(['get','post'], '/active/{customer_id}', 'BackEnd\users@active');
                            Route::match(['get','post'], '/edit/{customer_id}', 'BackEnd\users@edit');
                            Route::match(['get','post'], '/profile/{customer_id}', 'BackEnd\users@profile');*/
                        });



                // customers 
                Route::match(['get','post'], '/customers', 'BackEnd\users@customers');
                Route::group([
                    'prefix' => 'customer'], function(){

                        Route::match(['get','post'], '/delete/{customer_id}', 'BackEnd\users@delete');
                        Route::match(['get','post'], '/block/{customer_id}', 'BackEnd\users@block');
                        Route::match(['get','post'], '/active/{customer_id}', 'BackEnd\users@active');
                        Route::match(['get','post'], '/edit/{customer_id}', 'BackEnd\users@edit');
                        Route::match(['get','post'], '/profile/{customer_id}', 'BackEnd\users@profile');
                    });


                    //
          //  });  
    
});
//Route::match(['get','post'], '/api/users', 'Api\ApiController@index');
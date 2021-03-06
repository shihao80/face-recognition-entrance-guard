<?php

use Illuminate\Http\Request;
// use Symfony\Component\Routing\Annotation\Route;
use App\Http\Resources\RoleCollection;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use App\Role;
use App\Http\Resources\Role as RoleResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function($router) {

Route::prefix('auth')->group(function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');

});

Route::middleware('refresh.token')->group(function($router) {
    $router->get('profile','UserController@profile');
});

//角色
    Route::get('/roles','RoleController@index');
    Route::get('/roles/{role}','RoleController@show');

Route::middleware('refresh.token')->group(function($router) {
    Route::post('/roles','RoleController@store');
    Route::patch('/roles/{role}','RoleController@update');
    Route::delete('/roles/{role}','RoleController@destroy');
});

//权限
    Route::get('/permissions','PermissionController@index');
    Route::get('/permissions/{permission}','PermissionController@show');

Route::middleware('refresh.token')->group(function($router) {
    Route::post('/permissions','PermissionController@store');
    Route::patch('/permissions/{permission}','PermissionController@update');
    Route::delete('/permissions/{permission}','PermissionController@destroy');
});

//用户
    Route::get('/users/{user}','UserController@show');
Route::middleware('refresh.token')->group(function($router) {
    Route::get('/user_info','UserController@user_info');
    Route::get('/user_owner','UserController@user_owner');
    Route::get('/user_property','UserController@user_property');
    Route::get('/user_visiter','UserController@user_visiter');
    Route::get('/users','UserController@index');
    Route::post('/users','UserController@store');
    Route::patch('/users/{user}','UserController@update');
    Route::delete('/users/{user}','UserController@destroy');
});

//楼幢
    Route::get('/buildings','BuildingController@index');
    Route::get('/buildings/{building}','BuildingController@show');
Route::middleware('refresh.token')->group(function($router) {
    Route::post('/buildings','BuildingController@store');
    Route::patch('/buildings/{building}','BuildingController@update');
    Route::delete('/buildings/{building}','BuildingController@destroy');
});

//用户与角色
Route::middleware('refresh.token')->group(function($router) {
    Route::get('/users/{user}/roles','UserRoleController@roleIndex');
    Route::get('/roles/{role}/users','UserRoleController@userIndex');
    Route::post('/users/{user}/roles','UserRoleController@store');
    Route::delete('/users/{user}/roles/{role}','UserRoleController@destroy');
});

//角色与权限
Route::middleware('refresh.token')->group(function($router) {
    Route::get('/roles/{role}/permissions','RolePermissionController@permissionIndex');
    Route::post('/roles/{role}/permissions','RolePermissionController@store');
    Route::delete('/roles/{role}/permissions/{permission}','RolePermissionController@destroy');
});

//楼幢与住户地址
Route::get('/buildings/{building}/addresses','AddressController@addressIndex');
    Route::middleware('refresh.token')->group(function($router) {
    Route::post('/addresses','AddressController@store');
    Route::delete('/addresses/{address}','AddressController@destroy');
});

//用户与地址
// Route::middleware('refresh.token')->group(function($router) {
    Route::get('/users/{user}/addresses','UserAddressController@addressIndex');
    Route::get('/users/{user}/addresses/{address}','UserAddressController@userAddress');
    Route::get('/addresses/{address}/users','UserAddressController@userIndex');
    Route::post('/addresses/{address}/users','UserAddressController@store');
    Route::patch('/users/{user}/addresses/{address}','UserAddressController@update');
    Route::delete('/users/{user}/addresses/{address}','UserAddressController@destroy');
// });

//访问记录
Route::middleware('refresh.token')->group(function($router) {
    Route::get('/visits','VisitController@index');
    Route::get('/users/{user}/visits','VisitController@userIndex');
    Route::get('/buildings/{building}/visits','VisitController@buildingIndex');
    Route::get('/addresses/{address}/visits','VisitController@addressIndex');
    Route::post('/addresses/{address}/visits','VisitController@store');
});

//识别码
    Route::get('/users/{user}/codes','CodeController@show');
Route::middleware('refresh.token')->group(function($router) {
    Route::get('/codes','CodeController@index');
    Route::post('/users/{user}/codes','CodeController@store');
});

Route::post('auth/visit/{building}','VisitController@auth');

Route::post('auth/qrcode','VisitController@sendMsg');

Route::post('auth/{building}','FaceController@auth');

Route::post('visits/test','UserAddressController@test');

Route::get('pic/{path}','FaceController@pic_by_path');

Route::post('face/auth','FaceController@face_auth');

Route::get('user_code_pic/{code}','CodeController@get_pic');

Route::post('face/upload','FaceController@upload');

Route::post('face/face_id','FaceController@get_faceId');

Route::get('jpush/test','JPushController@PushTest');

Route::get('visit_latest','VisitController@latest');

Route::post('switch_auth','VisitController@switchAuth');

Route::post('change_user_state','VisitController@changeState');

Route::get('address_all','AddressController@addressAll');

});
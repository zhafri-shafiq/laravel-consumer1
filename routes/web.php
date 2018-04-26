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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/passport', function () {
    $query = http_build_query([
        'client_id'     => env('OAUTH_CLIENT_ID'),
        'redirect_uri'  => env('APP_URL') . 'callback',
        'response_type' => 'code',
        'scope'         => 'profile private',
    ]);

    return redirect(env('OAUTH_SERVER') . 'oauth/authorize?' . $query);
})->name('login.passport');

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post(env('OAUTH_SERVER') . 'oauth/token', [
        'form_params' => [
            'grant_type'    => 'authorization_code',
            'client_id'     => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'redirect_uri'  => env('APP_URL') . 'callback',
            'code'          => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

// Route::get('/passport', function () {
//     $http = new GuzzleHttp\Client;

//     $response = $http->post('http://passport.test/oauth/token', [
//         'form_params' => [
//             'grant_type'    => 'password',
//             'client_id'     => '2',
//             'client_secret' => 'ELKH5zBXdr1YkKSRpdAv8K039648mc0sJ5kvx9bN',
//             'username'      => 'zhafri@gmail.com',
//             'password'      => 'password',
//             'scope'         => '*',
//         ],
//     ]);

//     return $response;
//     // return json_decode((string) $response->getBody(), true);
// })->name('login.passport');

// Route::get('/user', function () {
//     $http = new GuzzleHttp\Client;

//     $response = $http->get('http://passport.test/api/auth/user', [
//         'headers' => [
//             'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjEwMTVjZmI3ZGU0YWYyM2ViNDhkMzExYTZhOWI4YjRkMDFkMDM3NzQ1MzQyMzEyMTI1NzEzOTk1ZmVkMjBkNDk5M2Q2ZmE2Y2Y0MjkwMGIwIn0.eyJhdWQiOiIyIiwianRpIjoiMTAxNWNmYjdkZTRhZjIzZWI0OGQzMTFhNmE5YjhiNGQwMWQwMzc3NDUzNDIzMTIxMjU3MTM5OTVmZWQyMGQ0OTkzZDZmYTZjZjQyOTAwYjAiLCJpYXQiOjE1MjQ2NDM1MzUsIm5iZiI6MTUyNDY0MzUzNSwiZXhwIjoxNTU2MTc5NTM1LCJzdWIiOiI3Iiwic2NvcGVzIjpbIioiXX0.NGzAyXGkavcX1vcgHVozT45buh0b_Pj6JGPebYbKEhDRP3owcvVc_EeOHbR_sRMgBxyhNaxMla3SYPqojzhIMjo0tBngH5Nqfe5MJzc7lK-o5cRTCnbUaW-NGCMW-7_ImoCpKKkhYlLAVo2eH3jtSxvPsiuZ5oH87bW0xW9BN3HW5XfeJOMmIIN0nylu95B-8D0hQMrhgylcRswraj3PJvgx8gmRJ9DgDsaO6VCMjZHwaK19d_HAPs-6G9xPCC_Cx0YP_z7bMepqJCifrdDjGS39qqodUWnIf-RBiZjzCjSNHlw6_Wi6KUlLSpXzxNPmX5Jl4z1-m-VirJUptcMSgdcFa0jdpgVwvRJ5ouTPrEl4bmpQ3A4otiwRQ_yxzq3ixBA1WqxiuP2qOd1CYRMjyth7-fAo2aEKoo20AX4IL5yxVDj-0lXdDG3dii2tXupd1For-keCiLaYTFF9SGT7S9GfWhOiiiuXr1oXyP8jxdQR7MhbA7UaQP3gq_4AT5wHpVqnJ-6BVLIfC8Cv1yzLMzzbMaaPDADaBBgPobsBq-BGg9flsywm3irWSen-dvOyBs_DyneEqxtHnsN2o9suVhTo-APwpKpO-w5zBlnZsuaVsvIIhkA78g8udHJLZUjIxoEcnNIxy_x9XXwpGDMT9b4zF_p85_ULZ9DWGkoVKEU',
//         ],
//     ]);

//     return $response;
//     // return json_decode((string) $response->getBody(), true);
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

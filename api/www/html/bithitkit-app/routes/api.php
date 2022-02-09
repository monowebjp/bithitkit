<?php

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogArticleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // $user->token
    $user = User::where('google_id', $googleUser->id)->first();

    if ($user) {
        $user->update([
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);
    } else {
        $user = User::create([
            'name' => $googleUser->name,
            'email'=>$googleUser->email,
            'google_id'=>$googleUser->id,
            'google_token'=>$googleUser->token,
            'google_refresh_token'=>$googleUser->refreshToken,
        ]);
    }

    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/', function () {
    return 'hello api';
});

Route::apiResource('blogArticle', BlogArticleController::class);

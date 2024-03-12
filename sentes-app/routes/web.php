<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\LocationController;
use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//******************** HOME ************************//
Route::get('/', function () {
    return view('home');
})->name('home');

//******************** ABOUT ************************//

Route::get('/about', function () {
    return view('about');
})->name('about');

//******************** LEGALS ************************//

Route::get('/legals', function () {
    return view('legals');
})->name('legals');

//******************** TERMS ************************//

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

//******************** REGISTER ************************//
Route::get('register', [RegisterController::class, 'create'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');

//******************** LOGIN ************************//
Route::get('login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('session', [SessionController::class, 'store'])->name('session.store')->middleware('guest');
Route::post('logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

//******************** FORGOT PASSWORD ************************//
Route::get('/forgot-password', function () {
    return view('session.forgotPassword');
})->name('password.request')->middleware('guest');

//******************** */ SEND RESET LINK ************************//
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    session()->flash('success', 'Un lien de réinitialisation de mot de passe t\'a été envoyé par mail !');
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

//******************** */ RESET PASSWORD FORM ************************//
Route::get('/reset-password/{token}', function (string $token) {
    return view('session.resetPassword', ['token' => $token, 'email' => request()->email]);
})->middleware('guest')->name('password.reset');

//******************** */ RESET PASSWORD ************************//
Route::post('/reset-password', function (Request $request) {
    // password must contain 1 number, 1 uppercase letter, 1 special character and be between 10 and 25 characters long :
    $passwordRegex = '/^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{10,25}$/';

    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required', 'min:10', 'max:25', 'confirmed', 'regex:' . $passwordRegex],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->setPasswordAttribute($password);
            $user->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
            session()->flash('success', 'Ton mot de passe a bien été réinitialisé !');
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : abort(403, __($status));
})->middleware('guest')->name('password.update');


//******************** EVENTS ************************//

Route::get('events', [EventController::class, 'index'])->name('events.index');

Route::get('events/create', [EventController::class, 'create'])->name('events.create')->middleware('auth');
Route::post('events', [EventController::class, 'store'])->name('events.store')->middleware('auth');

Route::get('events/create/{event}', [EventController::class, 'edit'])->name('events.edit');
Route::patch('events/create/{event}/2', [EventController::class, 'update'])->name('events.update');

Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

Route::post('events/{event}/subscribe', [AttendeeController::class, 'subscribeToEvent'])->name('attendee.subscribe')->middleware('auth');
Route::delete('events/{event}/unsubscribe', [AttendeeController::class, 'unsubscribeFromEvent'])->name('attendee.unsubscribe')->middleware('auth');

Route::patch('events/{event}/cancel', [EventController::class, 'cancel'])->name('event.cancel');

Route::get('pasts', [EventController::class, 'getPastsEvents'])->name('events.past');

//******************** LOCATIONS *******************/

Route::get('locations/{location}', [LocationController::class, 'getEventsByLocation'])->name('locations.show')->middleware('auth');

//******************** ADMIN CRUD *******************/

// route admin index

Route::get('admin', function () {
    return view('admin.index');
})->name('admin.index')->middleware('admin.custom');

// route admin users

Route::get('admin/users', [AdminController::class, 'userIndex'])->name('admin.users.index')->middleware('admin.custom');
Route::get('admin/users/{user}', [AdminController::class, 'userShow'])->name('admin.users.show')->middleware('admin.custom');
Route::get('admin/users/{user}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit')->middleware('admin.custom');
Route::patch('admin/users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update')->middleware('admin.custom');
Route::delete('admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy')->middleware('admin.custom');
Route::get('admin/createUser', [AdminController::class, 'userCreate'])->name('admin.users.create')->middleware('admin.custom');
Route::post('admin/users', [AdminController::class, 'userStore'])->name('admin.users.store')->middleware('admin.custom');

// route admin events

Route::get('admin/events', [AdminController::class, 'eventIndex'])->name('admin.events.index')->middleware('admin.custom');
Route::get('admin/events/{event}', [AdminController::class, 'eventShow'])->name('admin.events.show')->middleware('admin.custom');
Route::get('admin/events/{event}/edit', [AdminController::class, 'eventEdit'])->name('admin.events.edit')->middleware('admin.custom');
Route::patch('admin/events/{event}', [AdminController::class, 'eventUpdate'])->name('admin.events.update')->middleware('admin.custom');
Route::delete('admin/events/{event}', [AdminController::class, 'eventDestroy'])->name('admin.events.destroy')->middleware('admin.custom');
Route::get('admin/createEvent', [AdminController::class, 'eventCreate'])->name('admin.events.create')->middleware('admin.custom');
Route::post('admin/events', [AdminController::class, 'eventStore'])->name('admin.events.store')->middleware('admin.custom');

// route admin locations

Route::get('admin/locations', [AdminController::class, 'locationIndex'])->name('admin.locations.index')->middleware('admin.custom');
Route::get('admin/locations/{location}', [AdminController::class, 'locationShow'])->name('admin.locations.show')->middleware('admin.custom');
Route::get('admin/locations/{location}/edit', [AdminController::class, 'locationEdit'])->name('admin.locations.edit')->middleware('admin.custom');
Route::patch('admin/locations/{location}', [AdminController::class, 'locationUpdate'])->name('admin.locations.update')->middleware('admin.custom');
Route::delete('admin/locations/{location}', [AdminController::class, 'locationDestroy'])->name('admin.locations.destroy')->middleware('admin.custom');
Route::get('admin/createLocation', [AdminController::class, 'locationCreate'])->name('admin.locations.create')->middleware('admin.custom');
Route::post('admin/locations', [AdminController::class, 'locationStore'])->name('admin.locations.store')->middleware('admin.custom');

//*********************PROFILES AND USERS ***********************/

Route::get('user/public/profile/{user}', [RegisterController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('user/profile', [RegisterController::class, 'myProfile'])->name('profile.myProfile')->middleware('auth');
Route::get('users/{user}/edit', [RegisterController::class, 'edit'])->name('user.edit')->middleware('auth');
Route::patch('users/{user}/edit', [RegisterController::class, 'update'])->name('user.update')->middleware('auth');
Route::delete('users/{user}/delete', [RegisterController::class, 'destroy'])->name('user.delete')->middleware('auth');

Route::get('user/organisations/{user}/index', [EventController::class, 'getAllEventsOrganizedByUser'])->name('user.organisations.index')->middleware('auth');

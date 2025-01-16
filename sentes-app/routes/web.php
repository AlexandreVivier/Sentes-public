<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ArchetypeController;
use App\Http\Controllers\ArchetypeCategoryController;
use App\Http\Controllers\ArchetypeListController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\RitualController;
use App\Http\Controllers\RitualListController;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\BackgroundListController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityListController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\MiscellaneousListController;
use App\Http\Controllers\MiscellaneousCategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

//******************** EMAIL VERIFICATION ************************//
// Notice :
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
// La view envoyée est celle sur laquelle les users non vérifiés sont redirigés si ils tentent de se co.
// Penser au flashing message.

// Email verification request :
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return view('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend email verification link :
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Un nouveau lien de vérification t\'a été envoyé par mail !');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//******************** EVENTS ************************//

Route::get('events/all', [EventController::class, 'index'])->name('events.index');

Route::get('events/create', [EventController::class, 'create'])->name('events.create')->middleware(['auth', 'verified']);
Route::post('events', [EventController::class, 'store'])->name('events.store')->middleware(['auth', 'verified']);

Route::get('events/create/{event}', [EventController::class, 'edit'])->name('events.edit');
Route::patch('events/create/{event}/2', [EventController::class, 'update'])->name('events.update');

Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

Route::post('events/{event}/subscribe', [AttendeeController::class, 'subscribeToEvent'])->name('attendee.subscribe')->middleware(['auth', 'verified']);
Route::delete('events/{event}/unsubscribe', [AttendeeController::class, 'unsubscribeFromEvent'])->name('attendee.unsubscribe')->middleware(['auth', 'verified']);

Route::patch('events/{event}/cancel', [EventController::class, 'cancel'])->name('event.cancel');

Route::get('pasts', [EventController::class, 'getPastsEvents'])->name('events.past');

Route::get('events/{event}/edit', [EventController::class, 'change'])->name('event.change')->middleware(['auth', 'verified']);
Route::patch('events/{event}', [EventController::class, 'modify'])->name('event.modify')->middleware(['auth', 'verified']);

Route::patch('events/{event}/debrief', [EventController::class, 'postDateInfosUpdate'])->name('event.post.date.infos')->middleware(['auth', 'verified']);

Route::get('events/{event}/attendees', [AttendeeController::class, 'show'])->name('event.attendees.manage')->middleware(['auth', 'verified']);

Route::patch('events/{event}/attendees/{user}/promote', [AttendeeController::class, 'promoteOrganizer'])->name('event.attendees.promote')->middleware(['auth', 'verified']);
Route::patch('events/{event}/attendees/demote', [AttendeeController::class, 'demoteYourselfFromOrganizers'])->name('event.organizer.demote.self')->middleware(['auth', 'verified']);
Route::patch('events/{event}/attendees/{user}/status', [AttendeeController::class, 'setPaymentStatus'])->name('event.attendees.set.payment.status')->middleware(['auth', 'verified']);

//******************** PROFILES-Event *******************/

Route::patch('events/{event}/profile/publish', [ProfileController::class, 'publishEvent'])->name('event.profile.publish')->middleware(['auth', 'verified']);
Route::patch('events/{event}/profile/registrations', [ProfileController::class, 'openRegistrations'])->name('event.profile.registrations')->middleware(['auth', 'verified']);
Route::patch('events/{event}/profile/character-creation', [ProfileController::class, 'openCharacterCreation'])->name('event.profile.character.creation')->middleware(['auth', 'verified']);
Route::patch('events/{event}/profile/character-relations', [ProfileController::class, 'openCharacterRelations'])->name('event.profile.character.relations')->middleware(['auth', 'verified']);
Route::patch('events/{event}/profile/double-link', [ProfileController::class, 'allowDoubleLink'])->name('event.profile.double.link')->middleware(['auth', 'verified']);

//******************** CONTENT *******************/

Route::get('events/{event}/content', [ContentController::class, 'index'])->name('event.content.index')->middleware(['auth', 'verified']);
Route::get('events/{event}/content/create', [ContentController::class, 'create'])->name('event.content.create')->middleware(['auth', 'verified']);
Route::post('events/{event}/content', [ContentController::class, 'store'])->name('event.content.store')->middleware(['auth', 'verified']);
Route::delete('events/{event}/content/{content}', [ContentController::class, 'destroy'])->name('event.content.destroy')->middleware(['auth', 'verified']);
Route::get('events/{event}/content/{content}/edit', [ContentController::class, 'edit'])->name('event.content.edit')->middleware(['auth', 'verified']);
Route::patch('events/{event}/content/{content}/list', [ContentController::class, 'tableUpdate'])->name('content.table.update')->middleware(['auth', 'verified']);
Route::get('events/content/creation', [ContentController::class, 'creationIndex'])->name('event.content.creation')->middleware(['auth', 'verified']);
Route::get('events/content/{user}/creations', [ContentController::class, 'getCreationsByUser'])->name('event.content.creation.index')->middleware(['auth', 'verified']);

//******************** LOCATIONS *******************/

Route::get('locations/{location}', [LocationController::class, 'getEventsByLocation'])->name('locations.show');

//******************** ARCHETYPES *******************/
// Categories
Route::get('archetypes/categories', [ArchetypeCategoryController::class, 'index'])->name('archetypes.categories.index');
Route::get('archetypes/categories/create', [ArchetypeCategoryController::class, 'create'])->name('archetypes.categories.create');
Route::post('archetypes/categories', [ArchetypeCategoryController::class, 'store'])->name('archetypes.categories.store');
Route::get('archetypes/categories/{archetypeCategory}/edit', [ArchetypeCategoryController::class, 'edit'])->name('archetypes.categories.edit');
Route::patch('archetypes/categories/{archetypeCategory}', [ArchetypeCategoryController::class, 'update'])->name('archetypes.categories.update');
Route::delete('archetypes/categories/{archetypeCategory}', [ArchetypeCategoryController::class, 'destroy'])->name('archetypes.categories.destroy');
Route::get('archetypes/categories/{archetypeCategory}', [ArchetypeCategoryController::class, 'getArchetypeListsByCategory'])->name('archetypes.lists.categories.show');

//Archetypes Listes
Route::get('archetypes/list', [ArchetypeListController::class, 'index'])->name('archetypes.list.index');
Route::get('archetypes/list/{archetypeList}', [ArchetypeListController::class, 'show'])->name('archetypes.list.show');
Route::get('archetypes/create', [ArchetypeListController::class, 'create'])->name('archetypes.list.create');
Route::post('archetypes/store', [ArchetypeListController::class, 'store'])->name('archetypes.list.store');
Route::get('archetypes/{archetypeList}/edit', [ArchetypeListController::class, 'edit'])->name('archetypes.list.edit');
Route::patch('archetypes/list/update/{archetypeList}', [ArchetypeListController::class, 'update'])->name('archetypes.list.update');
Route::delete('archetypes/list/delete/{archetypeList}', [ArchetypeListController::class, 'destroy'])->name('archetypes.list.destroy');

//Archetypes
Route::get('archetypes/{archetypeList}/create', [ArchetypeController::class, 'create'])->name('archetypes.create');
Route::post('archetypes/{archetypeList}', [ArchetypeController::class, 'store'])->name('archetypes.store');
Route::get('archetypes/edit/{archetype}', [ArchetypeController::class, 'edit'])->name('archetypes.edit');
Route::patch('archetypes/update/{archetype}', [ArchetypeController::class, 'update'])->name('archetypes.update');
Route::delete('archetypes/delete/{archetype}', [ArchetypeController::class, 'destroy'])->name('archetypes.destroy');
Route::get('archetypes/{archetypeList}/download', [ArchetypeController::class, 'exportToCSV'])->name('archetypes.export');

//******************** COMMUNITIES *******************/
//Community Listes
Route::get('communities/list/index', [CommunityListController::class, 'index'])->name('communities.list.index');
Route::get('communities/{communityList}', [CommunityListController::class, 'show'])->name('communities.list.show');
Route::get('communities/list/create', [CommunityListController::class, 'create'])->name('communities.list.create');
Route::post('communities', [CommunityListController::class, 'store'])->name('communities.list.store');
Route::get('communities/{communityList}/edit', [CommunityListController::class, 'edit'])->name('communities.list.edit');
Route::patch('communities/{communityList}', [CommunityListController::class, 'update'])->name('communities.list.update');
Route::delete('communities/{communityList}', [CommunityListController::class, 'destroy'])->name('communities.list.destroy');

//Communities
Route::get('communities/{communityList}/create', [CommunityController::class, 'create'])->name('communities.create');
Route::post('communities/{communityList}', [CommunityController::class, 'store'])->name('communities.store');
Route::get('communities/edit/{community}', [CommunityController::class, 'edit'])->name('communities.edit');
Route::patch('communities/update/{community}', [CommunityController::class, 'update'])->name('communities.update');
Route::delete('communities/delete/{community}', [CommunityController::class, 'destroy'])->name('communities.destroy');
Route::get('communities/{communityList}/download', [CommunityController::class, 'exportToCSV'])->name('communities.export');

//******************** RITUALS *******************/
//Ritual Listes
Route::get('rituals/list/index', [RitualListController::class, 'index'])->name('rituals.list.index');
Route::get('rituals/{ritualList}', [RitualListController::class, 'show'])->name('rituals.list.show');
Route::get('rituals/list/create', [RitualListController::class, 'create'])->name('rituals.list.create');
Route::post('rituals', [RitualListController::class, 'store'])->name('rituals.list.store');
Route::get('rituals/{ritualList}/edit', [RitualListController::class, 'edit'])->name('rituals.list.edit');
Route::patch('rituals/{ritualList}', [RitualListController::class, 'update'])->name('rituals.list.update');
Route::delete('rituals/{ritualList}', [RitualListController::class, 'destroy'])->name('rituals.list.destroy');

//Rituals
Route::get('rituals/{ritualList}/create', [RitualController::class, 'create'])->name('rituals.create');
Route::post('rituals/{ritualList}', [RitualController::class, 'store'])->name('rituals.store');
Route::get('rituals/edit/{ritual}', [RitualController::class, 'edit'])->name('rituals.edit');
Route::patch('rituals/update/{ritual}', [RitualController::class, 'update'])->name('rituals.update');
Route::delete('rituals/delete/{ritual}', [RitualController::class, 'destroy'])->name('rituals.destroy');
Route::get('rituals/{ritualList}/download', [RitualController::class, 'exportToCSV'])->name('rituals.export');

//******************** BACKGROUNDS *******************/
//Background Listes
Route::get('backgrounds/list/index', [BackgroundListController::class, 'index'])->name('backgrounds.list.index');
Route::get('backgrounds/{backgroundList}', [BackgroundListController::class, 'show'])->name('backgrounds.list.show');
Route::get('backgrounds/list/create', [BackgroundListController::class, 'create'])->name('backgrounds.list.create');
Route::post('backgrounds', [BackgroundListController::class, 'store'])->name('backgrounds.list.store');
Route::get('backgrounds/{backgroundList}/edit', [BackgroundListController::class, 'edit'])->name('backgrounds.list.edit');
Route::patch('backgrounds/{backgroundList}', [BackgroundListController::class, 'update'])->name('backgrounds.list.update');
Route::delete('backgrounds/{backgroundList}', [BackgroundListController::class, 'destroy'])->name('backgrounds.list.destroy');

//Backgrounds
Route::get('backgrounds/{backgroundList}/create', [BackgroundController::class, 'create'])->name('backgrounds.create');
Route::post('backgrounds/{backgroundList}', [BackgroundController::class, 'store'])->name('backgrounds.store');
Route::get('backgrounds/edit/{background}', [BackgroundController::class, 'edit'])->name('backgrounds.edit');
Route::patch('backgrounds/update/{background}', [BackgroundController::class, 'update'])->name('backgrounds.update');
Route::delete('backgrounds/delete/{background}', [BackgroundController::class, 'destroy'])->name('backgrounds.destroy');
Route::get('backgrounds/{backgroundList}/download', [BackgroundController::class, 'exportToCSV'])->name('backgrounds.export');

//******************** MISCELLANEOUS ****************/
//Miscellaneous Categories
Route::get('miscellaneous/categories', [MiscellaneousCategoryController::class, 'index'])->name('miscellaneous.categories.index');
Route::get('miscellaneous/categories/create', [MiscellaneousCategoryController::class, 'create'])->name('miscellaneous.categories.create');
Route::post('miscellaneous/categories', [MiscellaneousCategoryController::class, 'store'])->name('miscellaneous.categories.store');
Route::get('miscellaneous/categories/{miscellaneousCategory}/edit', [MiscellaneousCategoryController::class, 'edit'])->name('miscellaneous.categories.edit');
Route::patch('miscellaneous/categories/{miscellaneousCategory}', [MiscellaneousCategoryController::class, 'update'])->name('miscellaneous.categories.update');
Route::delete('miscellaneous/categories/{miscellaneousCategory}', [MiscellaneousCategoryController::class, 'destroy'])->name('miscellaneous.categories.destroy');
Route::get('miscellaneous/categories/{miscellaneousCategory}', [MiscellaneousCategoryController::class, 'getAllMiscellaneousListsByCategory'])->name('miscellaneous.lists.categories.show');

//Miscellaneous Listes
Route::get('miscellaneous/list', [MiscellaneousListController::class, 'index'])->name('miscellaneous.list.index');
Route::get('miscellaneous/list/{miscellaneousList}', [MiscellaneousListController::class, 'show'])->name('miscellaneous.list.show');
Route::get('miscellaneous/create', [MiscellaneousListController::class, 'create'])->name('miscellaneous.list.create');
Route::post('miscellaneous/store', [MiscellaneousListController::class, 'store'])->name('miscellaneous.list.store');
Route::get('miscellaneous/{miscellaneousList}/edit', [MiscellaneousListController::class, 'edit'])->name('miscellaneous.list.edit');
Route::patch('miscellaneous/list/update/{miscellaneousList}', [MiscellaneousListController::class, 'update'])->name('miscellaneous.list.update');
Route::delete('miscellaneous/list/delete/{miscellaneousList}', [MiscellaneousListController::class, 'destroy'])->name('miscellaneous.list.destroy');

//Miscellaneous
Route::get('miscellaneous/{miscellaneousList}/create', [MiscellaneousController::class, 'create'])->name('miscellaneous.create');
Route::post('miscellaneous/{miscellaneousList}', [MiscellaneousController::class, 'store'])->name('miscellaneous.store');
Route::get('miscellaneous/edit/{miscellaneous}', [MiscellaneousController::class, 'edit'])->name('miscellaneous.edit');
Route::patch('miscellaneous/update/{miscellaneous}', [MiscellaneousController::class, 'update'])->name('miscellaneous.update');
Route::delete('miscellaneous/delete/{miscellaneous}', [MiscellaneousController::class, 'destroy'])->name('miscellaneous.destroy');
Route::get('miscellaneous/{miscellaneousList}/download', [MiscellaneousController::class, 'exportToCSV'])->name('miscellaneous.export');

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

Route::get('user/public/profile/{user}', [RegisterController::class, 'show'])->name('profile.show')->middleware(['auth', 'verified']);
Route::get('user/profile', [RegisterController::class, 'myProfile'])->name('profile.myProfile')->middleware(['auth', 'verified']);
Route::get('users/{user}/edit', [RegisterController::class, 'edit'])->name('user.edit')->middleware(['auth', 'verified']);
Route::patch('users/{user}/edit', [RegisterController::class, 'update'])->name('user.update')->middleware(['auth', 'verified']);
Route::delete('users/{user}/delete', [RegisterController::class, 'destroy'])->name('user.delete')->middleware(['auth', 'verified']);

Route::get('user/organisations/{user}/index', [EventController::class, 'getAllFutureEventsOrganizedByUser'])->name('user.organisations.index')->middleware(['auth', 'verified']);
Route::get('user/organisations/pasts/{user}/index', [EventController::class, 'getAllPastEventsOrganizedByUser'])->name('user.organisations.past.index')->middleware(['auth', 'verified']);
Route::get('user/organisations/cancelled/{user}/index', [EventController::class, 'getAllCancelledEventsOrganizedByUser'])->name('user.organisations.cancelled.index')->middleware(['auth', 'verified']);

Route::get('user/events/{user}/index', [EventController::class, 'getAllFutureEventsSubscribedByUser'])->name('user.events.index')->middleware(['auth', 'verified']);
Route::get('user/events/pasts/{user}/index', [EventController::class, 'getAllPastEventsSubscribedByUser'])->name('user.events.past.index')->middleware(['auth', 'verified']);
Route::get('user/events/cancelled/{user}/index', [EventController::class, 'getAllCancelledEventsSubscribedByUser'])->name('user.events.cancelled.index')->middleware(['auth', 'verified']);


//******************** NOTIFICATIONS ************************//

Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware(['auth', 'verified']);
Route::get('notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead')->middleware(['auth', 'verified']);
Route::get('notifications/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead')->middleware(['auth', 'verified']);
Route::get('notifications/{id}/markAsUnread', [NotificationController::class, 'markAsUnread'])->name('notifications.markAsUnread')->middleware(['auth', 'verified']);
Route::get('notifications/markAllAsUnread', [NotificationController::class, 'markAllAsUnread'])->name('notifications.markAllAsUnread')->middleware(['auth', 'verified']);

Route::get('notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete')->middleware(['auth', 'verified']);
Route::get('notifications/deleteAll', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll')->middleware(['auth', 'verified']);

Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show')->middleware(['auth', 'verified']);

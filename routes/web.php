<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});


Route::get('/download/{uuid}', 'FrontendController@download')->name('download');
Route::get('/v/preventivo/{uuid}', 'FrontendController@preLoadVisualizzaPreventivo')->name('preventivo');
Route::get('/preventivo/{uuid}', 'FrontendController@visualizzaPreventivo')->name('visualizza.preventivo');

Route::get('/accetta/preventivo/{uuid}', 'FrontendController@accettaPreventivo')->name('accetta.preventivo');
Route::get('/rifiuta/preventivo/{uuid}', 'FrontendController@rifiutaPreventivo')->name('rifiuta.preventivo');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Preventivo
    Route::delete('preventivos/destroy', 'PreventivoController@massDestroy')->name('preventivos.massDestroy');
    Route::post('preventivos/media', 'PreventivoController@storeMedia')->name('preventivos.storeMedia');
    Route::post('preventivos/ckmedia', 'PreventivoController@storeCKEditorImages')->name('preventivos.storeCKEditorImages');
    Route::resource('preventivos', 'PreventivoController');
    Route::post('preventivos/indexAjax', 'PreventivoController@indexAjax')->name('preventivos.indexAjax');


    Route::get('/duplica/preventivo/{id}', 'PreventivoController@duplicaPreventivo')->name('duplica.preventivo');
    Route::get('/table', 'PreventivoController@table');
    Route::get('/dataTable', 'PreventivoController@dataTable');
    Route::post('/dataTable-column-visibility', 'PreventivoController@columnVisibility');

    Route::get('/invia/preventivo/personalizzato/{id}', 'PreventivoController@inviaFilePersonalizzato')->name('invia.personalizzato');
    Route::get('/invia/preventivo/{id}', 'PreventivoController@inviaPreventivo')->name('invia.preventivo');

    // Report
    Route::get('/report/preventivo/data_creazione', 'ReportController@preventivoDataCreazione')->name('report.preventivo.dataCreazione');

    // Clienti
    Route::delete('clientis/destroy', 'ClientiController@massDestroy')->name('clientis.massDestroy');
    Route::resource('clientis', 'ClientiController');

    // Fornitore
    Route::delete('fornitores/destroy', 'FornitoreController@massDestroy')->name('fornitores.massDestroy');
    Route::resource('fornitores', 'FornitoreController');

    // Settings Dinamici
    Route::delete('settings-dinamicis/destroy', 'SettingsDinamiciController@massDestroy')->name('settings-dinamicis.massDestroy');
    Route::resource('settings-dinamicis', 'SettingsDinamiciController');

    // Scadenziario
    Route::delete('scadenziarios/destroy', 'ScadenziarioController@massDestroy')->name('scadenziarios.massDestroy');
    Route::resource('scadenziarios', 'ScadenziarioController');

    // Alloggio Hotel
    Route::delete('alloggio-hotels/destroy', 'AlloggioHotelController@massDestroy')->name('alloggio-hotels.massDestroy');
    Route::post('alloggio-hotels/media', 'AlloggioHotelController@storeMedia')->name('alloggio-hotels.storeMedia');
    Route::post('alloggio-hotels/ckmedia', 'AlloggioHotelController@storeCKEditorImages')->name('alloggio-hotels.storeCKEditorImages');
    Route::resource('alloggio-hotels', 'AlloggioHotelController');

    // Trasporto
    Route::delete('trasportos/destroy', 'TrasportoController@massDestroy')->name('trasportos.massDestroy');
    Route::post('trasportos/media', 'TrasportoController@storeMedia')->name('trasportos.storeMedia');
    Route::post('trasportos/ckmedia', 'TrasportoController@storeCKEditorImages')->name('trasportos.storeCKEditorImages');
    Route::resource('trasportos', 'TrasportoController');

    // Servizio Extra
    Route::delete('servizio-extras/destroy', 'ServizioExtraController@massDestroy')->name('servizio-extras.massDestroy');
    Route::post('servizio-extras/media', 'ServizioExtraController@storeMedia')->name('servizio-extras.storeMedia');
    Route::post('servizio-extras/ckmedia', 'ServizioExtraController@storeCKEditorImages')->name('servizio-extras.storeCKEditorImages');
    Route::resource('servizio-extras', 'ServizioExtraController');

    // Voce P Hotel Per Persona
    Route::delete('voce-p-hotel-per-personas/destroy', 'VocePHotelPerPersonaController@massDestroy')->name('voce-p-hotel-per-personas.massDestroy');
    Route::resource('voce-p-hotel-per-personas', 'VocePHotelPerPersonaController');

    // Voce P Hotel Per Notte
    Route::delete('voce-p-hotel-per-nottes/destroy', 'VocePHotelPerNotteController@massDestroy')->name('voce-p-hotel-per-nottes.massDestroy');
    Route::resource('voce-p-hotel-per-nottes', 'VocePHotelPerNotteController');

    // Voce P Hotel
    Route::delete('voce-p-hotels/destroy', 'VocePHotelController@massDestroy')->name('voce-p-hotels.massDestroy');
    Route::resource('voce-p-hotels', 'VocePHotelController');

    // Voce P Extra Per Persona
    Route::delete('voce-p-extra-per-personas/destroy', 'VocePExtraPerPersonaController@massDestroy')->name('voce-p-extra-per-personas.massDestroy');
    Route::resource('voce-p-extra-per-personas', 'VocePExtraPerPersonaController');

    // Voce P Extra Una Tantum
    Route::delete('voce-p-extra-una-tanta/destroy', 'VocePExtraUnaTantumController@massDestroy')->name('voce-p-extra-una-tanta.massDestroy');
    Route::resource('voce-p-extra-una-tanta', 'VocePExtraUnaTantumController');

    // Voce P Trasporto Per Persona
    Route::delete('voce-p-trasporto-per-personas/destroy', 'VocePTrasportoPerPersonaController@massDestroy')->name('voce-p-trasporto-per-personas.massDestroy');
    Route::resource('voce-p-trasporto-per-personas', 'VocePTrasportoPerPersonaController');

    // Itinerari
    Route::delete('itineraris/destroy', 'ItinerariController@massDestroy')->name('itineraris.massDestroy');
    Route::post('itineraris/media', 'ItinerariController@storeMedia')->name('itineraris.storeMedia');
    Route::post('itineraris/ckmedia', 'ItinerariController@storeCKEditorImages')->name('itineraris.storeCKEditorImages');
    Route::resource('itineraris', 'ItinerariController');

    Route::get('/duplica/itinerario/{id}', 'ItinerariController@duplica')->name('itineraris.duplica');


    // Voce P Trasporto Una Tantum
    Route::delete('voce-p-trasporto-una-tanta/destroy', 'VocePTrasportoUnaTantumController@massDestroy')->name('voce-p-trasporto-una-tanta.massDestroy');
    Route::resource('voce-p-trasporto-una-tanta', 'VocePTrasportoUnaTantumController');

    // Email Standard
    Route::delete('email-standards/destroy', 'EmailStandardController@massDestroy')->name('email-standards.massDestroy');
    Route::post('email-standards/media', 'EmailStandardController@storeMedia')->name('email-standards.storeMedia');
    Route::post('email-standards/ckmedia', 'EmailStandardController@storeCKEditorImages')->name('email-standards.storeCKEditorImages');
    Route::resource('email-standards', 'EmailStandardController');

    // Aziende Trasporti
    Route::delete('aziende-trasportis/destroy', 'AziendeTrasportiController@massDestroy')->name('aziende-trasportis.massDestroy');
    Route::post('aziende-trasportis/media', 'AziendeTrasportiController@storeMedia')->name('aziende-trasportis.storeMedia');
    Route::post('aziende-trasportis/ckmedia', 'AziendeTrasportiController@storeCKEditorImages')->name('aziende-trasportis.storeCKEditorImages');
    Route::resource('aziende-trasportis', 'AziendeTrasportiController');

    Route::get('scadenziario', 'TasksCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

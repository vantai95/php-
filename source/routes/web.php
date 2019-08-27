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

//Route::get('/sign-out', 'User\\HomesController@getSignOut');
Auth::routes();

Route::get('/', 'User\\HomesController@index');
Route::get('/home', 'User\\HomesController@index');
Route::get('/languages/{language}', 'User\\HomesController@changeLocalization');

//Subscribe
Route::post('/subscribe', 'User\\HomesController@subscribe');

//Service
Route::get('/services', 'User\\ServicesController@index');
Route::get('/services/detail/{slug}', [
    'as'    => 'services.detail',
    'uses'   => 'User\\ServicesController@detail'
]);

Route::post('/register-advice', 'User\\ServicesController@registerAdvice');
Route::post('/customer-service', 'User\\ServicesController@customerService');

//promotion
Route::get('/promotions', 'User\\PromotionController@index');
Route::get('/promotions/detail/{id}', [
    'as'   => 'promotion.detail',
    'uses' => 'User\\PromotionController@detail'
]);

//Events
Route::get('/events', 'User\\EventsController@index');
Route::get('/events/detail/{id}', 'User\\EventsController@detail');

//News
Route::get('/news/detail/{id}', 'User\\NewsController@detail');

//reset password
Route::get('/password/forgot-password','Auth\\ForgotPasswordController@resetPage');
Route::post('/password/create', 'Auth\\ForgotPasswordController@create');
Route::get('/password/find/{token}', 'Auth\\ForgotPasswordController@find');
Route::post('/password/reset', 'Auth\\ResetPasswordController@reset');

//Normal Menu
Route::get('/items','User\\ItemsController@itemsIndex');
Route::get('/items/{category}','User\\ItemsController@itemsIndex');
Route::get('/item','User\\ItemsController@itemsIndex');
Route::post('/items/add-to-cart','User\\ItemsController@addToCart');


//About Us
Route::get('/about-us/{slug}','User\\AboutUsController@index');

Route::post('/send-request','User\\ContactsController@store');
Route::get('/contacts','User\\ContactsController@index');

Route::get('/promotion-details/{page_url}', 'User\\PromotionDetailsController@index');

Route::get('/items/{category}','User\\ItemsController@itemsIndex');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//galleries
Route::get('/galleries', 'User\\GalleriesController@index');

// Admin Group
Route::group(['middleware' => ['translate', 'admin']], function () {


    // Admin dashboard
    Route::get('admin', 'Admin\\AdminsController@index');

    // Translation
    Route::get('admin/languages/{language}', 'Admin\\AdminsController@changeLocalization');

    // Manage admin profile
    Route::get('admin/my-profile', 'Admin\\UsersController@myProfile');
    Route::patch('admin/my-profile', 'Admin\\UsersController@updateProfile');
    Route::patch('admin/change-password', 'Admin\\UsersController@changePassword');
    // Permission middleware
    Route::group(['middleware' => ['permission']], function () {
      Route::get('admin/theme/customize',"Admin\\ThemeController@customize");
      Route::get('admin/theme/get-page-info/{id}',"Admin\\ThemeController@getPageInfo");
      Route::post('/admin/theme/update-section-data/{id}',"Admin\\ThemeController@updateSectionData");
        // Manage order
        Route::resource('admin/orders', 'Admin\\OrdersController',['except' => ['show']]);
        Route::get('admin/orders/booking', 'Admin\\OrdersController@booking');
        Route::get('admin/orders/booking/{id}/view', 'Admin\\OrdersController@viewBooking');
        Route::get('admin/orders/order', 'Admin\\OrdersController@order');
        Route::get('admin/orders/order/{id}/view', 'Admin\\OrdersController@viewOrder');

        // Manage Contacts
        Route::resource('admin/contacts', 'Admin\\ContactsController', ['except' => ['destroy', 'create', 'store']]);

        // Manage Categories
        Route::resource('admin/categories', 'Admin\\CategoriesController',['except' => ['show']]);
        Route::post('admin/categories/update-sequence', 'Admin\\CategoriesController@updateSequence');
        Route::get('admin/categories/categories-sequence', 'Admin\\CategoriesController@sequenceIndex');

        // Manage Sub Categories
        Route::resource('admin/sub-categories', 'Admin\\SubCategoriesController',['except' => ['show']]);
        Route::post('admin/sub-categories/update-sequence', 'Admin\\SubCategoriesController@updateSequence');
        Route::get('admin/sub-categories/sub-categories-sequence', 'Admin\\SubCategoriesController@sequenceIndex');
        Route::get('admin/sub-categories/get-sub-sub-categories/{id}', 'Admin\\SubCategoriesController@getSubSubCategories');

         // Manage Famous People
         Route::resource('admin/famous-people', 'Admin\\FamousPeopleController');
         Route::post('admin/famous-people/upload','Admin\\FamousPeopleController@upload');

        // Manage services
        Route::resource('admin/category-meta', 'Admin\\CategoryMetaController');
        Route::post('admin/category-meta/upload','Admin\\CategoryMetaController@upload');

        // Manage users
        Route::resource('admin/users', 'Admin\\UsersController', ['except' => ['create', 'store', 'edit', 'destroy']]);

        // Manage items
        Route::resource('admin/items', 'Admin\\ItemsController', ['except' => ['show']]);
        Route::get('admin/items/get-sub-categories/{id}', 'Admin\\ItemsController@getSubCategories');
//        Route::get('admin/items/get-items-data/{id}', 'Admin\\ItemsController@getItemsData');
//        Route::get('admin/items/get-all-items', 'Admin\\ItemsController@getAllItems');
        Route::post('admin/items/upload','Admin\\ItemsController@upload');
        Route::post('admin/items/update-sequence', 'Admin\\ItemsController@updateSequence');
        Route::get('admin/items/items-sequence', 'Admin\\ItemsController@sequenceIndex');
        Route::get('admin/items/get-sub-sub-categories/{id}', 'Admin\\ItemsController@getSubSubCategories');

        // Manage gallery types
        Route::resource('admin/gallery-types', 'Admin\\GalleryTypesController', ['except' => ['show']]);

        // Manage galleries
        Route::resource('admin/galleries','Admin\\GalleriesController', ['except' => ['show']]);
        Route::post('admin/galleries/upload','Admin\\GalleriesController@upload');

        // Manage menus
        Route::resource('admin/menus', 'Admin\\MenusController', ['except' => ['show']]);
        Route::post('admin/menus/update-sequence', 'Admin\\MenusController@updateSequence');
        Route::get('admin/menus/menus-sequence', 'Admin\\MenusController@sequenceIndex');

        // Manage sub_menus
        Route::resource('admin/sub-menus', 'Admin\\SubMenusController',['except' => ['show']]);
        Route::post('admin/sub-menus/update-sequence', 'Admin\\SubMenusController@updateSequence');
        Route::get('admin/sub-menus/sub-menus-sequence', 'Admin\\SubMenusController@sequenceIndex');

        // Manage event_types
        Route::resource('admin/event-types', 'Admin\\EventTypesController');

        // Manage events
        Route::resource('admin/events', 'Admin\\EventsController');
        Route::post('admin/events/upload','Admin\\EventsController@upload');

        // Manage news_types
        Route::resource('admin/news-types', 'Admin\\NewsTypesController');

        // Manage news
        Route::resource('admin/news', 'Admin\\NewsController');
        Route::post('admin/news/upload','Admin\\NewsController@upload');

        // Manage services
        Route::resource('admin/services', 'Admin\\ServicesController');
        Route::post('admin/services/upload','Admin\\ServicesController@upload');

        // Manage promotions
        Route::resource('admin/promotions', 'Admin\\PromotionsController', ['except' => ['show']]);
        Route::post('admin/promotions/upload','Admin\\PromotionsController@upload');
        Route::get('admin/promotions/promotions-sequence', 'Admin\\PromotionsController@sequenceIndex');
        Route::post('admin/promotions/update-sequence', 'Admin\\PromotionsController@updateSequence');

        // Manage currencies exchange rate
        Route::resource('admin/currencies', 'Admin\\CurrenciesController');

        // Manage configurations
        Route::get('admin/configurations', 'Admin\\ConfigurationsController@index');
        Route::post('admin/configurations', 'Admin\\ConfigurationsController@update');
        Route::post('admin/configurations/upload','Admin\\ConfigurationsController@upload');

        //Manage Roles
        Route::resource('admin/roles','Admin\\RolesController');
        Route::post('admin/add-user/{id}','Admin\\RolesController@updateUserRole');
        Route::post('admin/delete-user/{id}','Admin\\RolesController@deleteUserRole');

        //Manage payment-methods
        Route::resource('admin/payment-methods', 'Admin\\PaymentMethodsController');

        //Manage email-templates
        Route::resource('admin/email-templates', 'Admin\\EmailTemplatesController');


        //Manage aboutsus
        Route::resource('admin/about-us', 'Admin\\AboutUsController');
        Route::post('admin/about-us/upload','Admin\\AboutUsController@upload');

        //Manage image list
        Route::resource('admin/image-list', 'Admin\\ImagesController');
        Route::post('admin/image-list/upload','Admin\\ImagesController@upload');
        Route::post('admin/upload-new-image','Admin\\ImagesController@uploadNewImage');
        Route::post('admin/upload-new-thumb-image','Admin\\ImagesController@uploadThumb');
        Route::post('admin/upload-image-list','Admin\\ImagesController@uploadImageList');
        Route::post('admin/delete-images','Admin\\ImagesController@deleteImages');
        Route::get('admin/get-img-list','Admin\\ImagesController@getImageList');

        // Manage FAQ
        Route::resource('admin/faqs', 'Admin\\FaqsController');

        // Manage customer feedback
        Route::resource('admin/service-feedbacks', 'Admin\\ServiceFeedbacksController');

    });
});

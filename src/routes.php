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

Route::model('gallery', 'ZaLaravel\LaravelGallery\Models\Gallery');
Route::resource('/admin/gallery', 'ZaLaravel\LaravelGallery\Controllers\AdminGalleryController');

/*Route::get('/gallery/{gslug}', [
    'uses' =>'GalleryController@index',
    'as' => 'gallery.index'
]);

Route::bind('gslug', function($slug){
    return \ZaLaravel\LaravelGallery\Models\Interfaces\GalleryInterface::where('slug', '=', $slug)->firstOrFail();
});*/
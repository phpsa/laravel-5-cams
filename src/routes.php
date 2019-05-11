<?php


use  Phpsa\Datastore\Http\Controllers\Admin\Controller as AdminController;
use  Phpsa\Datastore\Http\Controllers\DatastoreController;

use App\Http\Controllers\Frontend\ContactController;


//Route::get('datastore_tests', [PageController::class, 'tests'])->name('dstests');

$prefix = config("datastore.urlprefix");

Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.ams.', 'middleware' => ['admin',  'permission:manage datastore']], function () {
	Route::get('ams/slug', [AdminController::class, 'slug'])->name('content.slug');
	Route::get('ams/inject', [AdminController::class, 'inject'])->name('content.inject');
	Route::get('ams/list/{asset}', [AdminController::class, 'list'])->name('content.list');
	Route::get('ams/create/{asset}', [AdminController::class, 'create'])->name('content.create');
	Route::get('ams/edit/{asset}/{id}', [AdminController::class, 'edit'])->name('content.update');
	Route::post('ams/save/{asset}', [AdminController::class, 'save'])->name('content.save');
	Route::delete('ams/delete/{id}', [AdminController::class, 'destroy'])->name('content.destroy');
});

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.ams.', 'prefix' => $prefix ], function () {
	Route::get('{slug}', [DatastoreController::class, 'page'])->name('page.slug');
	Route::get('{id}', [DatastoreController::class, 'pageById'])->name('page.id');
	Route::get('{id}/{slug}', [DatastoreController::class, 'pageById'])->name('page.id.slug');
});


/*
Route::get('user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
*/
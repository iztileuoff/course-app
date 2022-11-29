<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DragdropController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('check', [AuthController::class, 'check'])->name('check');

    Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::post('lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('lessons/{id}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('lessons/{id}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    Route::get('files', [FileController::class, 'index'])->name('files.index');
    Route::post('files', [FileController::class, 'store'])->name('files.store');
    Route::get('files/{id}', [FileController::class, 'show'])->name('files.show');
    Route::post('files/{id}', [FileController::class, 'update'])->name('files.update');
    Route::delete('files/{id}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
    Route::post('videos', [VideoController::class, 'store'])->name('videos.store');
    Route::get('videos/{id}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('videos/{id}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');

    Route::get('texts', [TextController::class, 'index'])->name('texts.index');
    Route::post('texts', [TextController::class, 'store'])->name('texts.store');
    Route::get('texts/{id}', [TextController::class, 'show'])->name('texts.show');
    Route::post('texts/{id}', [TextController::class, 'update'])->name('texts.update');
    Route::delete('texts/{id}', [TextController::class, 'destroy'])->name('texts.destroy');

    Route::get('photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('photos/{id}', [PhotoController::class, 'show'])->name('photos.show');
    Route::post('photos/{id}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    Route::get('tests', [TestController::class, 'index'])->name('tests.index');
    Route::post('tests', [TestController::class, 'store'])->name('tests.store');
    Route::get('tests/{id}', [TestController::class, 'show'])->name('tests.show');
    Route::post('tests/{id}', [TestController::class, 'update'])->name('tests.update');
    Route::delete('tests/{id}', [TestController::class, 'destroy'])->name('tests.destroy');

    Route::get('answers', [AnswerController::class, 'index'])->name('answers.index');
    Route::post('answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('answers/{id}', [AnswerController::class, 'show'])->name('answers.show');
    Route::post('answers/{id}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy');

    Route::get('dragdrops', [DragdropController::class, 'index'])->name('dragdrops.index');
    Route::post('dragdrops', [DragdropController::class, 'store'])->name('dragdrops.store');
    Route::get('dragdrops/{id}', [DragdropController::class, 'show'])->name('dragdrops.show');
    Route::post('dragdrops/{id}', [DragdropController::class, 'update'])->name('dragdrops.update');
    Route::delete('dragdrops/{id}', [DragdropController::class, 'destroy'])->name('dragdrops.destroy');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveySectionController;
use App\Http\Controllers\UserController;
use App\Models\SurveySection;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['auth'])->group(function () {

    // Route::get('/',[Dashboard::class,'index'])->name('index');

    // Route::get('/', function () {
    //     return view('users/index');
    // })->name('index');

    //Users
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/show', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');

    //Surveys
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys/store', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('/surveys/show', [SurveyController::class, 'show'])->name('surveys.show');
    Route::get('/surveys/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::post('/surveys/update', [SurveyController::class, 'update'])->name('surveys.update');

    //Sections
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections/store', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/show', [SectionController::class, 'show'])->name('sections.show');
    Route::get('/sections/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::post('/sections/update', [SectionController::class, 'update'])->name('sections.update');

    //SurveySections
    Route::get('/surveysections', [SurveySectionController::class, 'index'])->name('surveysections.index');
    Route::get('/surveysections/create', [SurveySectionController::class, 'create'])->name('surveysections.create');
    Route::post('/surveysections/store', [SurveySectionController::class, 'store'])->name('surveysections.store');
    Route::get('/surveysections/edit', [SurveySectionController::class, 'edit'])->name('surveysections.edit');
    Route::post('/surveysections/update', [SurveySectionController::class, 'update'])->name('surveysections.update');

    //Questions
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/show', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/questions/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/questions/update', [QuestionController::class, 'update'])->name('questions.update');
    Route::get('/section_questions', [QuestionController::class, 'section_questions'])->name('questions.section_questions');

    //Options
    Route::get('/options', [OptionController::class, 'index'])->name('options.index');
    Route::get('/questionOptions', [OptionController::class, 'questionOptions'])->name('options.questionOptions');
    Route::get('/options/create', [OptionController::class, 'create'])->name('options.create');
    Route::post('/options/store', [OptionController::class, 'store'])->name('options.store');
    Route::get('/options/edit', [OptionController::class, 'edit'])->name('options.edit');
    Route::post('/options/update', [OptionController::class, 'update'])->name('options.update');
    Route::get('/question_options', [OptionController::class, 'question_options'])->name('options.question_options');

    //Responses
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/show', [ParticipantController::class, 'show'])->name('participants.show');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/show', [RoleController::class, 'show'])->name('roles.show');

    //Global
    Route::post('/change_status', [GlobalController::class, 'change_status'])->name('change_status');
    Route::post('/custom_delete', [GlobalController::class, 'custom_delete'])->name('custom_delete');
    Route::post('/row_reorder', [GlobalController::class, 'row_reorder'])->name('row_reorder');

    //Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/test', [AuthController::class, 'test'])->name('test');
    Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

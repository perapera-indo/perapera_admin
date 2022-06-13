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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('test', function () {
    return view('backend.receipt.invoice');
});

Route::get('/login', array(
    'as'    => 'login',
    'uses'  => 'Auth\LoginController@login'
));

Route::post('/post-login', array(
    'as'    => 'postLogin',
    'uses'  => 'Auth\LoginController@postLogin'
));

Auth::routes();

Route::get('/force-logout', array(
    'as'    => 'forceLogout',
    'uses'  => 'Auth\LoginController@forceLogout'
));

// route access permission optional for action if data null true by default
Route::group(['middleware' => 'sentinelAuth','namespace' => 'Admin','prefix' => 'account'], function () {
    Route::get('change-password', 'AccountController@changePassword')->name('account.change_password');
    Route::put('change-password', 'AccountController@postChangePassword')->name('account.post_change_password');
});

// route access permission required for action default is false
Route::group(['middleware' => ['sentinelAuth','checkAccess'],'namespace' => 'Admin','prefix' => 'admin'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('role', 'RoleController')->except('show');
    Route::resource('permission', 'PermissionController')->only(['index','edit','update']);
    Route::resource('user', 'UserController')->except('show');
    Route::resource('settings', 'SettingController')->only(['index','edit','update']);
    Route::resource('member', 'MemberController')->only(['index','edit','update']);
    Route::resource('room', 'RoomController');

    Route::resource('letter-categories', 'A\LetterCategoryController')->except('show');
    Route::resource('letters', 'A\LetterController')->except('show');
    Route::resource('letter-courses', 'A\LetterCourseController')->except('show');
    Route::resource('letter-questions', 'A\LetterCourseQuestionController')->except('show');

    Route::get('letters/1/index', 'A\LetterController@categoryindex')->name('letter-hiragana-list');
    Route::get('letters/2/index', 'A\LetterController@categoryindex')->name('letter-katakana-list');
    Route::get('letters/{cid}/add', 'A\LetterController@newcreate')->name('letter-cat-get-add');
    Route::post('letters/{cid}/add', 'A\LetterController@categorystore')->name('letter-cat-add');
    Route::get('letters/{letter_category_id}/edit/{id}', 'A\LetterController@categoryedit')->name('letter-cat-edit');
    Route::put('letters/{letter_category_id}/edit/{id}', 'A\LetterController@categoryupdate')->name('letter-cat-update');

    Route::resource('letters/hiragana', 'A\LetterController')->except('show');
    Route::resource('letters/katakana', 'A\LetterController')->except('show');

    Route::group(['namespace'=>'Bunpou', 'prefix' =>'bunpou', 'as'=>'bunpou.'], function () {
        Route::resource('intro', 'BunpouController')->except('show');

        Route::group(['prefix' =>'module/test', 'as'=>'module.test.'], function () {
            Route::get('/', 'BunpouModuleTestController@redirect')->name("redirect");
            Route::put('{id}/deactivate', 'BunpouModuleTestController@deactivate')->name('deactivate');
            Route::put('{id}/activate', 'BunpouModuleTestController@activate')->name('activate');
            Route::delete('{id}/destroy', 'BunpouModuleTestController@destroy')->name('destroy');
            Route::get('{id}/edit', 'BunpouModuleTestController@edit')->name('edit');
            Route::get('{module}/create', 'BunpouModuleTestController@create')->name('create');
            Route::post('store', 'BunpouModuleTestController@store')->name('store');
            Route::put('{id}/update', 'BunpouModuleTestController@update')->name('update');
            Route::get('{module}', 'BunpouModuleTestController@index')->name('index');
        });
        Route::group(['prefix' =>'module/question', 'as'=>'module.question.'], function () {
            Route::get('/', 'BunpouModuleQuestionController@redirect')->name("redirect");
            Route::put('{id}/deactivate', 'BunpouModuleQuestionController@deactivate')->name('deactivate');
            Route::put('{id}/activate', 'BunpouModuleQuestionController@activate')->name('activate');
            Route::delete('{id}/destroy', 'BunpouModuleQuestionController@destroy')->name('destroy');
            Route::get('{id}/edit', 'BunpouModuleQuestionController@edit')->name('edit');
            Route::get('{test}/create', 'BunpouModuleQuestionController@create')->name('create');
            Route::post('store', 'BunpouModuleQuestionController@store')->name('store');
            Route::put('{id}/update', 'BunpouModuleQuestionController@update')->name('update');
            Route::get('{test}', 'BunpouModuleQuestionController@index')->name('index');
        });
        Route::resource('module', 'BunpouModulesController');
        Route::put('module/{id}/activate', 'BunpouModulesController@activate')->name('module.activate');
        Route::put('module/{id}/deactivate', 'BunpouModulesController@deactivate')->name('module.deactivate');

        Route::resource('chapter', 'BunpouChaptersController')->except('show');
        Route::put('chapter/{id}/activate', 'BunpouChaptersController@activate')->name('chapter.activate');
        Route::put('chapter/{id}/deactivate', 'BunpouChaptersController@deactivate')->name('chapter.deactivate');

        Route::group(['prefix' =>'chapter', 'as'=>'chapter.'], function () {
            Route::get('/', 'BunpouChaptersController@redirect')->name("redirect");
            Route::put('{id}/deactivate', 'BunpouChaptersController@deactivate')->name('deactivate');
            Route::put('{id}/activate', 'BunpouChaptersController@activate')->name('activate');
            Route::delete('{id}/destroy', 'BunpouChaptersController@destroy')->name('destroy');
            Route::get('{id}/edit', 'BunpouChaptersController@edit')->name('edit');
            Route::get('{module}/create', 'BunpouChaptersController@create')->name('create');
            Route::post('store', 'BunpouChaptersController@store')->name('store');
            Route::put('{id}/update', 'BunpouChaptersController@update')->name('update');
            Route::get('{module}', 'BunpouChaptersController@index')->name('index');
        });

        Route::group(['prefix' =>'vocabulary', 'as'=>'vocabulary.'], function () {
            Route::get('/', 'BunpouVocabController@redirect')->name("redirect");
            Route::put('{id}/deactivate', 'BunpouVocabController@deactivate')->name('deactivate');
            Route::put('{id}/activate', 'BunpouVocabController@activate')->name('activate');
            Route::delete('{id}/destroy', 'BunpouVocabController@destroy')->name('destroy');
            Route::get('{id}/edit', 'BunpouVocabController@edit')->name('edit');
            Route::get('{chapter}/create', 'BunpouVocabController@create')->name('create');
            Route::post('store', 'BunpouVocabController@store')->name('store');
            Route::put('{id}/update', 'BunpouVocabController@update')->name('update');
            Route::get('{chapter}', 'BunpouVocabController@index')->name('index');
        });
    });

    // Route::resource('verb-levels', 'B\MasterVerbLevelController')->except('show');
    // Route::resource('verb-groups', 'B\MasterVerbGroupController')->except('show');
    // Route::resource('verb-words', 'B\MasterVerbWordController')->except('show');
    // Route::resource('verb-changes', 'B\VerbChangeController')->except('show');
    // Route::resource('verb-sentences', 'B\MasterVerbSentenceController')->except('show');
    // Route::resource('verb-courses', 'B\VerbCourseController')->except('show');
    // Route::resource('verb-questions', 'B\VerbCourseQuestionController')->except('show');
    // Route::resource('verb-mini-courses', 'B\VerbMiniCourseController')->except('show');
    // Route::resource('verb-mini-questions', 'B\VerbMiniCourseQuestionController')->except('show');

    // Route::resource('particle-education-chapters', 'C\ParticleEducationChapterController')->except('show');
    // Route::resource('particle-educations', 'C\ParticleEducationController')->except('show');
    // Route::resource('particle-education-details', 'C\ParticleEducationDetailController')->except('show');
    // Route::resource('particle-courses', 'C\ParticleCourseController')->except('show');
    // Route::resource('particle-course-questions', 'C\ParticleCourseQuestionController')->except('show');
    // Route::resource('particle-mini-courses', 'C\ParticleMiniCourseController')->except('show');
    // Route::resource('particle-mini-course-questions', 'C\ParticleMiniCourseQuestionController')->except('show');

    // Route::resource('pattern-chapters', 'D\PatternChapterController')->except('show');
    // Route::resource('pattern-lessons', 'D\PatternLessonController')->except('show');
    // Route::resource('pattern-lesson-details', 'D\PatternLessonDetailController')->except('show');
    // Route::resource('pattern-courses', 'D\PatternCourseController')->except('show');
    // Route::resource('pattern-course-questions', 'D\PatternCourseQuestionController')->except('show');
    // Route::resource('pattern-mini-courses', 'D\PatternMiniCourseController')->except('show');
    // Route::resource('pattern-mini-course-questions', 'D\PatternMiniCourseQuestionController')->except('show');

    // Route::get('pattern-lessons/{id}/detail-index', 'D\PatternLessonDetailController@index')->name('lesson-detail-index');
    // Route::get('pattern-lessons/{id}/details', 'D\PatternLessonDetailController@create')->name('lesson-detail-add');
    // Route::post('pattern-lessons/{id}/details', 'D\PatternLessonDetailController@store')->name('lesson-detail-post');
    // Route::get('pattern-lessons/{id}/detail-edit/{did}', 'D\PatternLessonDetailController@edit')->name('lesson-detail-edit');
    // Route::put('pattern-lessons/{id}/detail-edit/{did}', 'D\PatternLessonDetailController@update')->name('lesson-detail-update');

    // Route::get('pattern-lessons/{id}/details/{did}/index', 'D\PatternLessonDetailExampleController@index')->name('lesson-detail-example-index');
    // Route::get('pattern-lessons/{id}/details/{did}', 'D\PatternLessonDetailExampleController@create')->name('lesson-detail-example-add');
    // Route::post('pattern-lessons/{id}/details/{did}', 'D\PatternLessonDetailExampleController@store')->name('lesson-detail-example-post');
    // Route::get('pattern-lessons/{id}/details/{did}/example/{eid}', 'D\PatternLessonDetailExampleController@edit')->name('lesson-detail-example-edit');
    // Route::put('pattern-lessons/{id}/details/{did}/example/{eid}', 'D\PatternLessonDetailExampleController@update')->name('lesson-detail-example-update');

    // Route::resource('master-groups', 'E\MasterGroupController')->except('show');

    // Route::resource('kanji-chapters', 'E\KanjiChapterController')->except('show');

    // Route::get('kanji-chapters/{id}/content-index', 'E\KanjiContentController@index')->name('kanji-contents-index');
    // Route::get('kanji-chapters/{id}/contents', 'E\KanjiContentController@create')->name('kanji-contents-create');
    // Route::post('kanji-chapters/{id}/contents', 'E\KanjiContentController@store')->name('kanji-contents-store');
    // Route::get('kanji-chapters/{id}/content-edit/{did}', 'E\KanjiContentController@edit')->name('kanji-contents-edit');
    // Route::put('kanji-chapters/{id}/content-edit/{did}', 'E\KanjiContentController@update')->name('kanji-contents-update');

    // // Route::resource('kanji-contents', 'E\KanjiContentController')->except('show');
    // Route::resource('kanji-educations', 'E\KanjiEducationController')->except('show');
    // Route::resource('kanji-samples', 'E\KanjiSampleController')->except('show');
    // Route::resource('kanji-courses', 'E\KanjiCourseController')->except('show');
    // Route::resource('kanji-course-questions', 'E\KanjiCourseQuestionController')->except('show');
    // Route::resource('kanji-mini-courses', 'E\KanjiMiniCourseController')->except('show');
    // Route::resource('kanji-mini-course-questions', 'E\KanjiMiniCourseQuestionController')->except('show');

    Route::resource('vocabulary-chapters', 'F\VocabularyChapterController')->except('show');
    Route::resource('vocabulary-course-chapters', 'F\VocabularyCourseChapterController')->except('show');
    Route::resource('vocabularies', 'F\VocabularyController')->except('show');
    Route::resource('vocabulary-courses', 'F\VocabularyCourseController')->except('show');
    Route::resource('vocabulary-course-questions', 'F\VocabularyCourseQuestionController')->except('show');
    Route::resource('vocabulary-mini-course-chapters', 'F\VocabularyMiniCourseChapterController')->except('show');
    Route::resource('vocabulary-mini-courses', 'F\VocabularyMiniCourseController')->except('show');
    Route::resource('vocabulary-mini-course-questions', 'F\VocabularyMiniCourseQuestionController')->except('show');

    // Route::resource('master-ability-courses', 'G\MasterAbilityCourseController')->except('show');
    // Route::resource('master-ability-course-levels', 'G\MasterAbilityCourseLevelController')->except('show');

    // Route::resource('ability-courses', 'G\AbilityCourseController')->except('show');
    // Route::resource('ability-course-question-groups', 'G\AbilityCourseQuestionGroupController')->except('show');
    // Route::resource('ability-course-question-groups/{id}/ability-questions', 'G\AbilityCourseQuestionController')->except('show');
    // Route::resource('ability-course-questions', 'G\AbilityCourseQuestionController')->except('show');
    // Route::resource('ability-course-chapters', 'G\AbilityCourseChapterController')->except('show');

    // Route::get('pattern-lessons/{id}/details/{did}/index', 'D\PatternLessonDetailExampleController@index')->name('lesson-detail-example-index');
    // Route::get('pattern-lessons/{id}/details/{did}', 'D\PatternLessonDetailExampleController@create')->name('lesson-detail-example-add');
    // Route::post('pattern-lessons/{id}/details/{did}', 'D\PatternLessonDetailExampleController@store')->name('lesson-detail-example-post');
    // Route::get('pattern-lessons/{id}/details/{did}/example/{eid}', 'D\PatternLessonDetailExampleController@edit')->name('lesson-detail-example-edit');
    // Route::put('pattern-lessons/{id}/details/{did}/example/{eid}', 'D\PatternLessonDetailExampleController@update')->name('lesson-detail-example-update');

});

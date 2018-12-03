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
$secretRoute = Config::get('constant')['secretRoute'];

Route::group(['namespace' => 'BackEnd','prefix' => $secretRoute], function()
{
    Route::group(['namespace' => 'Capacity'], function()
    {
		Route::get('capacity-config', 'ConfigController@index');

		Route::get('member', 'MemberController@index');
		Route::post('member/lists', 'MemberController@lists');
		Route::post('member/create', 'MemberController@create');
		Route::post('member', 'MemberController@store');
		Route::post('member/edit/{id}', 'MemberController@edit');
		Route::patch('member/{id}', 'MemberController@update');
		Route::delete('member', 'MemberController@destroy');

		Route::get('room', 'RoomController@index');
		Route::post('room/lists', 'RoomController@lists');
		Route::post('room/create', 'RoomController@create');
		Route::post('room', 'RoomController@store');
		Route::post('room/edit/{id}', 'RoomController@edit');
		Route::patch('room/{id}', 'RoomController@update');
		Route::delete('room', 'RoomController@destroy');

		Route::get('subject', 'SubjectController@index');
		Route::post('subject/lists', 'SubjectController@lists');
		Route::post('subject/create', 'SubjectController@create');
		Route::post('subject', 'SubjectController@store');
		Route::post('subject/edit/{id}', 'SubjectController@edit');
		Route::patch('subject/{id}', 'SubjectController@update');
		Route::delete('subject', 'SubjectController@destroy');

		Route::get('location', 'LocationController@index');
		Route::post('location/lists', 'LocationController@lists');
		Route::post('location/create', 'LocationController@create');
		Route::post('location', 'LocationController@store');
		Route::post('location/edit/{id}', 'LocationController@edit');
		Route::patch('location/{id}', 'LocationController@update');
		Route::delete('location', 'LocationController@destroy');

		Route::get('survey-template','SurveyTemplateController@index');
		Route::post('survey-template/lists', 'SurveyTemplateController@lists');
		Route::post('survey-template/create', 'SurveyTemplateController@create');
		Route::post('survey-template', 'SurveyTemplateController@store');
		Route::post('survey-template/{id}', 'SurveyTemplateController@show');
		Route::post('survey-template/edit/{id}', 'SurveyTemplateController@edit');
		Route::patch('survey-template/{id}', 'SurveyTemplateController@update');
		Route::delete('survey-template', 'SurveyTemplateController@destroy');

		Route::get('question', 'QuestionController@index');
		Route::post('question/lists', 'QuestionController@lists');
		Route::post('question/create', 'QuestionController@create');
		Route::post('question', 'QuestionController@store');
		Route::post('question/{id}', 'QuestionController@show');
		Route::post('question/edit/{id}', 'QuestionController@edit');
		Route::patch('question/{id}', 'QuestionController@update');
		Route::delete('question', 'QuestionController@destroy');

		Route::get('course', 'CourseController@index');
		Route::post('course/lists', 'CourseController@lists');
		Route::post('course/create', 'CourseController@create');
		Route::post('course', 'CourseController@store');
		Route::post('course/show/{id}', 'CourseController@show');
		Route::post('course/edit/{id}', 'CourseController@edit');
		Route::patch('course/{id}', 'CourseController@update');
		Route::delete('course', 'CourseController@destroy');
		Route::get('course/basic/{id}', 'CourseController@basic');
		Route::get('course/survey/{id}', 'CourseController@survey');
		Route::get('course/survey/{course_id}/lists', 'CourseController@surveyList');
		Route::post('course/survey/{course_id}/create', 'CourseController@surveyCreate');
		Route::post('course/survey/{course_id}/store', 'CourseController@surveyStore');

		Route::get('training', 'TrainingController@index');
		Route::post('training/lists', 'TrainingController@lists');
		Route::post('training/create', 'TrainingController@create');
		Route::post('training/store', 'TrainingController@store');
		Route::post('training/edit/{id}', 'TrainingController@edit');
		Route::patch('training/update/{id}', 'TrainingController@update');
		Route::delete('training/delete', 'TrainingController@destroy');
		Route::post('training/detail/{id}', 'TrainingController@show');
		Route::get('training/basic/{id}', 'TrainingController@basic');
		Route::post('training/assign/{id}', 'TrainingController@createParticipant');
		Route::post('training/assign-store/{id}', 'TrainingController@storeParticipant');
		Route::get('training/schedule/{id}', 'TrainingController@schedule');
		Route::post('schedule/busy-coordinate', 'ScheduleController@busyCoordinate');
		Route::get('schedule/{training}', 'ScheduleController@index');
		Route::post('schedule/{training}/create', 'ScheduleController@create');
		Route::post('schedule/{schedule}/copy', 'ScheduleController@copy');
		Route::post('schedule/{training}', 'ScheduleController@store');
		Route::post('schedule/{id}/edit', 'ScheduleController@edit');
		Route::patch('schedule/{id}', 'ScheduleController@update');
		Route::delete('schedule/{id}', 'ScheduleController@destroy');
		Route::get('training/attendance/{id}', 'TrainingController@attendance');
		Route::get('training/survey/{id}', 'TrainingController@survey');
		Route::get('training/document/{id}', 'TrainingController@document');
		Route::post('training/{id}/assign-participants', 'TrainingController@assignParticipants');
		Route::post('training/course-data', 'TrainingController@getcoursebyid');
    });

    Route::group(['namespace' => 'File'], function()
    {
		Route::post('/upload','UploadController@upload');
		Route::get('/upload-list','UploadController@uploadList');
		Route::post('/upload-delete','UploadController@uploadDelete');
		Route::post('/upload-temp-delete','UploadController@uploadTempDelete');
	});

    Route::group(['namespace' => 'OutsideStaff'], function()
    {
        Route::get('outside-staff/index', 'OutsideStaffController@index');
        Route::post('outside-staff/lists', 'OutsideStaffController@lists');
        Route::post('outside-staff/create', 'OutsideStaffController@create');
        Route::post('outside-staff/edit', 'OutsideStaffController@edit');
        Route::post('outside-staff/delete', 'OutsideStaffController@delete');
        Route::post('outside-staff', 'OutsideStaffController@store');
    });
	
	Route::group(['namespace' => 'Document'], function (){
		Route::post('tracking', 'TrackingController@store');
		Route::post('tracking/setting', 'TrackingController@postSetting');
		Route::get('tracking/s', 'TrackingController@postSetting');
		Route::post('tracking/lists', 'TrackingController@lists');
	});

});

/* 
	go to new style of routing 
	frontend block
*/
Route::get('/switch','ConfigurationController@switchs');

Route::group(['namespace' => 'FrontEnd'],function(){
	Route::post('/notification','NotificationController@index');
	Route::post('/notification/{id}','NotificationController@update');
});


Route::get('/', 'FrontendController@getIndex');
Route::get($secretRoute.'/change-password', 'BackEnd\User\UserController@getChangePassword');
Route::get($secretRoute.'/config', 'BackEnd\Config\ConfigController@getIndex');
Route::get($secretRoute.'/downloads', 'FrontEnd\Download\DownloadController@getDownloadExcel');
Route::get('/attendance-mail/{key}', 'PublicController@getUserReq');
Route::get($secretRoute.'/officer-report', 'BackEnd\Officer\OfficerController@geOfficerReport');
Route::get($secretRoute.'/officer-dashboard', 'BackEnd\Officer\OfficerController@geOfficerDashboard');
Route::get($secretRoute.'/officer/edit/{id}', 'BackEnd\Officer\OfficerController@getEdit');
Route::get($secretRoute.'/documents/setting', 'BackEnd\Document\DocumentController@setting');

#Route::get($secretRoute.'/tracking', 'BackEnd\Document\TrackingController@getIndex');
#Route::post($secretRoute.'/tracking/new', 'BackEnd\Document\TrackingController@postNew');


Route::controllers([
	// Back-End
    'auth'                          	                =>'Auth\AuthController',
	$secretRoute.'/role'       			                =>'BackEnd\User\RoleController',
	$secretRoute.'/user'       			                =>'BackEnd\User\UserController',
	$secretRoute.'/give-room-access'     			    =>'BackEnd\GiveRoomAccess\GiveRoomAccessController',


	$secretRoute.'/resource'        	                =>'BackEnd\User\ResourceController',
	$secretRoute.'/front-end-resource'           =>'BackEnd\User\FrontEndResourceController',
	$secretRoute.'/config'      		                    =>'BackEnd\Config\ConfigController',
	$secretRoute.'/central-ministry'	                =>'BackEnd\CentralMinistry\CentralMinistryController',
	$secretRoute.'/position'      		                =>'BackEnd\Position\PositionController',
	$secretRoute.'/department'      	                =>'BackEnd\Department\DepartmentController',
	$secretRoute.'/general-department'         =>'BackEnd\GeneralDepartment\GeneralDepartmentController',
	$secretRoute.'/office'  			                    =>'BackEnd\Office\OfficeController',
	$secretRoute.'/printCard'  			                =>'BackEnd\PrintCard\PrintCardController',
	$secretRoute.'/organization-chat'  			        =>'BackEnd\OrganizationChat\OrganizationChatController',
	$secretRoute.'/officer'  			                 =>'BackEnd\Officer\OfficerController',
	$secretRoute.'/dashboard'  			            =>'BackEnd\Dashboard\DashboardController',
	$secretRoute.'/class-rank'  		                =>'BackEnd\ClassRank\ClassRankController',
	$secretRoute.'/degree'  			                =>'BackEnd\Degree\DegreeController',
	$secretRoute.'/skill'  				                    =>'BackEnd\Degree\SkillController',
	$secretRoute.'/language'  			                =>'BackEnd\Language\LanguageController',
	$secretRoute.'/push-back'  			            =>'BackEnd\PushBack\PushBackController',
    $secretRoute.'/title'  			                        =>'BackEnd\Title\TitleController',
	
	$secretRoute.'/meeting'  			                =>'BackEnd\Schedule\MeetingController',
	$secretRoute.'/meeting-type'  		                =>'BackEnd\Schedule\MeetingTypeController',
	$secretRoute.'/meeting-leader'  	                =>'BackEnd\Schedule\MeetingLeaderController',
	$secretRoute.'/public-holiday'                      =>'BackEnd\Holiday\PublicHolidayController',
	$secretRoute.'/meeting-room'                        =>'BackEnd\Schedule\MeetingRoomController',
	$secretRoute.'/meeting-pending'                     =>'BackEnd\Schedule\MeetingPendingController',
	
	$secretRoute.'/takeleave-approve'  	        =>'BackEnd\Attendance\AttendanceApproveController',
	$secretRoute.'/takeleave-type'  	            =>'BackEnd\Attendance\AttendanceTypeController',
	$secretRoute.'/takeleave-user'  	            =>'BackEnd\Attendance\AttendanceUserController',
	$secretRoute.'/takeleave-report'  	            =>'BackEnd\Attendance\AttendanceReportController',
	$secretRoute.'/takeleave-role'  	                =>'BackEnd\Attendance\AttendanceRoleController',
	$secretRoute.'/letter-mission'  	                =>'BackEnd\Attendance\LetterMissionController',
	
	$secretRoute.'/attendance-officer'           =>'BackEnd\Attendance\AttendanceOfficerController',
	$secretRoute.'/officer-checkin'  	            =>'BackEnd\Attendance\OfficerCheckinController',
	$secretRoute.'/officer-checkin-report'      =>'BackEnd\Attendance\OfficerCheckinReportController',
	$secretRoute.'/door-tracking'      	            =>'BackEnd\Attendance\DoorTrackingController',
    $secretRoute.'/file'      	                            =>'BackEnd\File\FileController',
	$secretRoute.'/present-of-week'               =>'BackEnd\Attendance\PresentOfWeekController',
	$secretRoute.'/monthly-report'     	        =>'BackEnd\Attendance\MonthlyReportController',


	$secretRoute.'/tags'		                        =>'BackEnd\News\TagsController',
	$secretRoute.'/news'  				                =>'BackEnd\News\NewsController',
	$secretRoute.'/news-category'		                =>'BackEnd\News\NewsCategoryController',
	
	$secretRoute.'/mission-type'  		                =>'BackEnd\Mission\MissionTypeController',
	$secretRoute.'/mission'  			                =>'BackEnd\Mission\MissionController',
	
	$secretRoute.'/province'  			                =>'BackEnd\CurrentAddress\ProvinceController',
	$secretRoute.'/district'  			                =>'BackEnd\CurrentAddress\DistrictController',
	$secretRoute.'/commune'  			                =>'BackEnd\CurrentAddress\CommuneController',
	$secretRoute.'/village'  			                =>'BackEnd\CurrentAddress\VillageController',
	$secretRoute.'/special-day'  		                =>'BackEnd\SpecialDays\SpecialDaysController',

    //document management
    $secretRoute.'/documents-type'  			    =>'BackEnd\Document\DocumentTypeController',
    $secretRoute.'/private-sector'  			    =>'BackEnd\Document\PrivateSectorController',
    $secretRoute.'/documents'  			            =>'BackEnd\Document\DocumentController',
    $secretRoute.'/tracking'  			            =>'BackEnd\Document\TrackingController',

    /******************************Frontend************************/
	'emoji'       						=>'FrontEnd\Emoji\EmojiController',
	'profile'       					=>'FrontEnd\Register\ProfileController',
	'attendance'  						=>'FrontEnd\Attendance\AttendanceController',
	'login'       						=>'FrontEnd\Register\RegisterController',
	'register'       					=>'FrontEnd\Register\RegisterController',
	'background-staff-gov-info'       	=>'FrontEnd\BackgroundStaffGovInfo\BackgroundStaffGovInfoController',
	'download'       					=>'FrontEnd\Download\DownloadController',
	'updateInfo'       					=>'FrontEnd\UpdateInfomation\UpdateInfoController',
    'summary-all-form'       			=>'FrontEnd\BackgroundStaffGovInfo\SummaryAllFormController',
    'schedule'       			        =>'FrontEnd\Schedule\ScheduleController',
    'news'       			            =>'FrontEnd\News\NewsController',
    'tv'       			            	=>'FrontEnd\TV\TVController',
    'chat'       			            =>'FrontEnd\Chat\ChatController',
	'template'                         	=> 'FrontEnd\Template\TemplateController',
	'privacy-policy'       				=>'FrontEnd\Template\PrivacyController',
]);


Route::get('path/{filename}', function ($filename)
{
    $path = storage_path() . '/' . $filename;
    if(!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/register/activate/{code}', [
    'as'    => 'activate',
    'uses'  => 'RegisterController@activate'
]);
Route::get('session',function(){
    $session= Session::get('sessionGuestUser');
    $session_alive = $session == null ? false:true;
    return json_encode($session_alive);
});
Route::get('life-time',function(){
    $session= Session::get('sessionUser');
    $session_alive = $session == null ? false:true;
    return json_encode($session_alive);
});

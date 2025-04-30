<?php

use App\Exports\StudentTemplateExport;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController as SUPERADMINUSER;
use App\Http\Controllers\SuperAdmin\ParentController as SUPERADMINORANGTUA;
use App\Http\Controllers\SuperAdmin\VideoController as SUPERADMINVIDEO;
use App\Http\Controllers\SuperAdmin\PhotoController as SUPERADMINPHOTO;
use App\Http\Controllers\SuperAdmin\SchoolController as SUPERADMINSCHOOL;
use App\Http\Controllers\SuperAdmin\ClassController as SUPERADMINCLASS;
use App\Http\Controllers\SuperAdmin\StudentController as SUPERADMINSTUDENT;
use App\Http\Controllers\SuperAdmin\LessonPlanController as SUPERADMINLSPLAN;
use App\Http\Controllers\SuperAdmin\SchoolInfoController as SUPERADMINSCHOOLINFO;
use App\Http\Controllers\SuperAdmin\DelightController as SUPERADMINDELIGHT;

use App\Http\Controllers\Superadmin\ManageUserSchoolController as SUPERADMINMANAGE;
use App\Http\Controllers\Superadmin\ManageTeacherClassController as SUPERADMINMANAGETEACHER;




use App\Http\Controllers\TuSekolah\TuSekolahController;
use App\Http\Controllers\TuSekolah\SchoolController as TusekolahSCHOOL;
use App\Http\Controllers\TuSekolah\ClassController as TusekolahCLASS;
use App\Http\Controllers\TuSekolah\StudentController as TusekolahSTUDENT;
use App\Http\Controllers\TuSekolah\EreportController as TusekolahEREPORT;





use App\Http\Controllers\TuSekolah\UserController as TuUser;


use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\UserController as GuruUser;
use App\Http\Controllers\Guru\StudentController as GuruStudent;
use App\Http\Controllers\Guru\SchoolController as GuruSchool;
use App\Http\Controllers\Guru\ClassController as GuruClass;
use App\Http\Controllers\Guru\EreportController as GuruEreport;
use App\Http\Controllers\Guru\PhotoController as GURUPHOTO;
use App\Http\Controllers\Guru\LessonPlanController as GURULSPLAN;
use App\Http\Controllers\Guru\SubPhotoController as GURUSUBPHOTO;






use App\Http\Controllers\TuKeuangan\TuKeuanganController;
use App\Http\Controllers\OrangTua\OrangTuaController;
use App\Http\Controllers\KeuanganPusat\KeuanganPusatController;
use App\Http\Controllers\StudentImportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([
    'register' => false, // Nonaktifkan rute registrasi
]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('superadmin')->middleware(['auth', 'level:SUPERADMIN'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

    # Untuk Aksi Data Users
    Route::get('/users', [SUPERADMINUSER::class, 'index'])->name('superadmin.users.index');
    Route::post('/users', [SUPERADMINUSER::class, 'store'])->name('superadmin.users.store');
    Route::put('/users/{id}', [SUPERADMINUSER::class, 'update'])->name('superadmin.users.update');
    Route::delete('/users/{id}', [SUPERADMINUSER::class, 'destroy'])->name('superadmin.users.destroy');

    # Untuk Aksi Data User Orang Tua
    Route::get('/users-parent', [SUPERADMINORANGTUA::class, 'index'])->name('superadmin.parent.index');
    Route::post('/users-parent', [SUPERADMINORANGTUA::class, 'store'])->name('superadmin.parent.store');
    Route::post('/users-parent/assign', [SUPERADMINORANGTUA::class, 'assign'])->name('superadmin.parent.assign');
    // Route::post('/manage-parent', [SUPERADMINORANGTUA::class, 'store'])->name('superadmin.parent.store');
    Route::post('/parent/{id}/update-students', [SUPERADMINORANGTUA::class, 'updateStudents'])->name('parents.updateStudents');

    // Route::delete('/parents/{parentId}/remove-student/{studentId}', [SUPERADMINORANGTUA::class, 'removeStudent'])->name('parents.removeStudent');

    // Route::delete('/parents/{parent}/remove-student/{student}', [SUPERADMINORANGTUA::class, 'removeStudent'])
    //     ->name('parents.removeStudent');

    Route::delete('/parents/{parent}/remove-student/{student}', [SUPERADMINORANGTUA::class, 'removeStudent'])->name('parents.removeStudent');



    Route::put('/users-parent/{id}', [SUPERADMINORANGTUA::class, 'update'])->name('superadmin.parent.update');
    Route::delete('/users-parent/{id}', [SUPERADMINORANGTUA::class, 'destroy'])->name('superadmin.parent.destroy');
    // Route::get('/users', [SUPERADMINUSER::class, 'index'])->name('superadmin.users.index');
    // Route::post('/users', [SUPERADMINUSER::class, 'store'])->name('superadmin.users.store');
    // Route::put('/users/{id}', [SUPERADMINUSER::class, 'update'])->name('superadmin.users.update');
    // Route::delete('/users/{id}', [SUPERADMINUSER::class, 'destroy'])->name('superadmin.users.destroy');

    # Untuk Aksi Data Schools
    Route::get('/schools', [SUPERADMINSCHOOL::class, 'index'])->name('superadmin.schools.index');
    Route::post('/schools', [SUPERADMINSCHOOL::class, 'store'])->name('superadmin.schools.store');
    Route::put('/schools/{school_id}', [SUPERADMINSCHOOL::class, 'update'])->name('superadmin.schools.update');
    Route::delete('/schools/{school_id}', [SUPERADMINSCHOOL::class, 'destroy'])->name('superadmin.schools.destroy');


    Route::get('/kelas/{school_id}', [SUPERADMINCLASS::class, 'index'])->name('superadmin.kelas.index');
    Route::post('/kelas/store', [SUPERADMINCLASS::class, 'store'])->name('superadmin.kelas.store');
    Route::put('/kelas/{class_id}', [SUPERADMINCLASS::class, 'update'])->name('superadmin.kelas.update');
    Route::delete('/kelas/{class_id}', [SUPERADMINCLASS::class, 'destroy'])->name('superadmin.kelas.destroy');


    Route::get('/student/{school_id}', [SUPERADMINSTUDENT::class, 'index'])->name('superadmin.students.index');
    Route::post('/students/store', [SUPERADMINSTUDENT::class, 'store'])->name('superadmin.students.store');
    Route::put('/students/{student_id}', [SUPERADMINSTUDENT::class, 'update'])->name('superadmin.students.update');
    Route::delete('/students/{student_id}', [SUPERADMINSTUDENT::class, 'destroy'])->name('superadmin.students.destroy');


    Route::get('/lsplans/{school_id}', [SUPERADMINLSPLAN::class, 'index'])->name('superadmin.lsplans.index');
    Route::post('/lsplans/store', [SUPERADMINLSPLAN::class, 'store'])->name('superadmin.lsplans.store');
    Route::put('/lsplans/{id}', [SUPERADMINLSPLAN::class, 'update'])->name('superadmin.lsplans.update');
    Route::delete('/lsplans/{id}', [SUPERADMINLSPLAN::class, 'destroy'])->name('superadmin.lsplans.destroy');


    Route::get('/import', [StudentImportController::class, 'showImportForm']);
    Route::post('/import', [StudentImportController::class, 'import'])->name('superadmin.students.import');

    Route::get('/students/template', function () {
        return Excel::download(new StudentTemplateExport, 'Student_Template.xlsx');
    })->name('students.template');

    # Untuk Aksi Data Videos
    Route::get('/videos', [SUPERADMINVIDEO::class, 'index'])->name('superadmin.videos.index');
    Route::post('/videos', [SUPERADMINVIDEO::class, 'store'])->name('superadmin.videos.store');
    Route::get('/videos/get-classes', [SUPERADMINVIDEO::class, 'getClasses'])->name('superadmin.videos.getClasses');
    Route::put('/videos/{id}', [SUPERADMINVIDEO::class, 'update'])->name('superadmin.videos.update');
    Route::delete('/videos/{id}', [SUPERADMINVIDEO::class, 'destroy'])->name('superadmin.videos.destroy');


    Route::get('/schoolInfo', [SUPERADMINSCHOOLINFO::class, 'index'])->name('superadmin.schoolInfo.index');
    Route::post('/schoolInfo', [SUPERADMINSCHOOLINFO::class, 'store'])->name('superadmin.schoolInfo.store');
    Route::put('/schoolInfo/{id}', [SUPERADMINSCHOOLINFO::class, 'update'])->name('superadmin.schoolInfo.update');
    Route::delete('/schoolInfo/{id}', [SUPERADMINSCHOOLINFO::class, 'destroy'])->name('superadmin.schoolInfo.destroy');
    

    Route::get('/delight', [SUPERADMINDELIGHT::class, 'index'])->name('superadmin.delight.index');
    Route::post('/delight', [SUPERADMINDELIGHT::class, 'store'])->name('superadmin.delight.store');
    Route::put('/delight/{id}', [SUPERADMINDELIGHT::class, 'update'])->name('superadmin.delight.update');
    Route::delete('/delight/{id}', [SUPERADMINDELIGHT::class, 'destroy'])->name('superadmin.delight.destroy');





    # Untuk Aksi Data Photos
    Route::get('/photos', [SUPERADMINPHOTO::class, 'index'])->name('superadmin.photos.index');
    Route::post('/photos', [SUPERADMINPHOTO::class, 'store'])->name('superadmin.photos.store');
    Route::delete('/photos/{id}', [SUPERADMINPHOTO::class, 'destroy'])->name('superadmin.photos.destroy');


    Route::get('/photos/get-classes', [SUPERADMINPHOTO::class, 'getClasses'])->name('superadmin.photos.getClasses');
    Route::get('/photos/get-students', [SUPERADMINPHOTO::class, 'getStudents'])->name('superadmin.photos.getStudents');


    Route::get('/manage-userschools', [SUPERADMINMANAGE::class, 'index'])->name('superadmin.manage-userschools');
    Route::post('/manage-userschools', [SUPERADMINMANAGE::class, 'store'])->name('superadmin.manage-userschools.store');
    Route::put('/superadmin/manage-userschools/{id}', [SUPERADMINMANAGE::class, 'update'])
        ->name('superadmin.manage-userschools.update');
    Route::delete('/superadmin.manage-userschools/{id}', [SUPERADMINMANAGE::class, 'destroy'])
        ->name('superadmin.manage-userschools.destroy');

    Route::post('/manage-teacher', [SUPERADMINMANAGETEACHER::class, 'store'])->name('superadmin.manage-teacher.store');
    Route::delete('/manage-teacher/{id}', [SUPERADMINMANAGETEACHER::class, 'destroy'])
        ->name('superadmin.manage-teacher.destroy');
});


Route::prefix('tusekolah')->middleware(['auth', 'level:TUSEKOLAH'])->group(function () {
    Route::get('/dashboard', [TuSekolahController::class, 'index'])->name('tusekolah.dashboard');

    Route::get('/users', [TuUser::class, 'index'])->name('tusekolah.users.index');
    Route::delete('/users/{id}', [TuUser::class, 'destroy'])->name('users.destroy');

    # Untuk Aksi Data Schools
    Route::get('/schools', [TusekolahSCHOOL::class, 'index'])->name('tusekolah.schools.index');
    Route::post('/schools', [TusekolahSCHOOL::class, 'store'])->name('tusekolah.schools.store');
    Route::put('/schools/{id}', [TusekolahSCHOOL::class, 'update'])->name('tusekolah.schools.update');
    Route::delete('/schools/{id}', [TusekolahSCHOOL::class, 'destroy'])->name('tusekolah.schools.destroy');


    # Untuk Aksi Data Class
    Route::get('/classes', [TusekolahCLASS::class, 'index'])->name('tusekolah.classes.index');
    Route::post('/classes', [TusekolahCLASS::class, 'store'])->name('tusekolah.classes.store');
    Route::put('/classes/{id}', [TusekolahCLASS::class, 'update'])->name('tusekolah.classes.update');
    Route::delete('/classes/{id}', [TusekolahCLASS::class, 'destroy'])->name('tusekolah.classes.destroy');

    Route::get('/students', [TusekolahSTUDENT::class, 'index'])->name('tusekolah.students.index');
    Route::post('/students', [TusekolahSTUDENT::class, 'store'])->name('tusekolah.students.store');
    Route::put('/students/{id}', [TusekolahSTUDENT::class, 'update'])->name('tusekolah.students.update');

    Route::get('/students/get-classes', [TusekolahSTUDENT::class, 'getClasses'])->name('tusekolah.students.getClasses');

    Route::get('/ereports', [TusekolahEREPORT::class, 'index'])->name('tusekolah.ereports.index');
    Route::delete('/ereports/{id}', [TusekolahEREPORT::class, 'destroy'])->name('tusekolah.ereports.destroy');
});


Route::prefix('guru')->middleware(['auth', 'level:GURU'])->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');

    Route::get('/users', [GuruUser::class, 'index'])->name('guru.users.index');
    Route::delete('/users/{id}', [GuruUser::class, 'destroy'])->name('guru.destroy');

    Route::get('/student/{id}', [GuruStudent::class, 'index'])->name('guru.students.index');

    # Untuk Aksi Data Schools
    Route::get('/schools', [GuruSchool::class, 'index'])->name('guru.schools.index');
    Route::delete('/schools/{id}', [GuruSchool::class, 'destroy'])->name('guru.schools.destroy');

    # Untuk Aksi Data Class
    Route::get('/classes', [GuruClass::class, 'index'])->name('guru.classes.index');
    Route::delete('/classes/{id}', [GuruClass::class, 'destroy'])->name('guru.classes.destroy');

    Route::get('/eraports', [GuruEreport::class, 'index'])->name('guru.eraports.index');
    Route::delete('/eraports/{id}', [GuruEreport::class, 'destroy'])->name('guru.eraports.destroy');

    Route::get('/lsplans/{class_id}', [GURULSPLAN::class, 'index'])->name('guru.lsplans.index');
    Route::post('/lsplans/store', [GURULSPLAN::class, 'store'])->name('guru.lsplans.store');
    Route::put('/lsplans/{id}', [GURULSPLAN::class, 'update'])->name('guru.lsplans.update');
    Route::delete('/lsplans/{id}', [GURULSPLAN::class, 'destroy'])->name('guru.lsplans.destroy');

    # Untuk Aksi Data Photos
    Route::get('/photos', [GURUPHOTO::class, 'index'])->name('guru.photos.index');
    Route::post('/photos', [GURUPHOTO::class, 'store'])->name('guru.photos.store');
    Route::put('/photos/{id}', [GURUPHOTO::class, 'update'])->name('guru.photos.update');
    Route::delete('/photos/{id}', [GURUPHOTO::class, 'destroy'])->name('guru.photos.destroy');

    # Sub Photo
    Route::get('/subphoto/{id}', [GURUSUBPHOTO::class, 'index'])->name('guru.subphoto.index');
    Route::post('/subphoto/store', [GURUSUBPHOTO::class, 'store'])->name('guru.subphoto.store');
    Route::post('/subphoto/destroy/{id}', [GURUSUBPHOTO::class, 'destroy'])->name('guru.subphoto.destroy');
});






Route::prefix('tukeuangan')->middleware(['auth', 'level:TUKEUANGAN'])->group(function () {
    Route::get('/dashboard', [TuKeuanganController::class, 'index'])->name('tukeuangan.dashboard');
});

Route::prefix('tukeuanganpusat')->middleware(['auth', 'level:KEUANGANPUSAT'])->group(function () {
    Route::get('/dashboard', [KeuanganPusatController::class, 'index'])->name('keuanganpusat.dashboard');
});



Route::prefix('orangtua')->middleware(['auth', 'level:ORANGTUA'])->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'index'])->name('orangtua.dashboard');
});

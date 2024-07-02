<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciaestController;


Route::group(['prefix' => 'asistencias_est',  'middleware' =>'auth_docentes'], function(){
    Route::get('/', [AsistenciaestController::class, 'index'])->name('asistencias_est.index');
    Route::post('/delete/{id}', [AsistenciaestController::class, 'destroy'])->name('asistencias_est.destroy');
});

Route::get('/create', [AsistenciaestController::class, 'create'])->name('asistencias_est.create');
Route::post('/create', [AsistenciaestController::class, 'store'])->name('asistencias_est.store');
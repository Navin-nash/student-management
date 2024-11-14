<?php
use App\Http\Controllers\Controller;

// Alternatively, if you want to load the StudentController
Route::get('/students', [Controller::class, 'index']);
Route::post('/student', [Controller::class, 'store']);
Route::put('/student/{id}', [Controller::class, 'update']);
Route::delete('/student/{id}', [Controller::class, 'destroy']);

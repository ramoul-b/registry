<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RegistryController;
use App\Http\Controllers\Api\V1\TypeController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AttributeController;
use App\Http\Controllers\Api\V1\CategoryController;


    // RegistryController  management
    Route::get('/registry', [RegistryController::class, 'index']);
    Route::post('/registries', [RegistryController::class, 'store']);
    Route::get('/registries/{id}', [RegistryController::class, 'show']);
    Route::put('/registries/{id}', [RegistryController::class, 'update']);
    Route::delete('/registries/{id}', [RegistryController::class, 'destroy']);


    // TypeController  management
    Route::get('/types', [TypeController::class, 'index']);
    Route::post('/types', [TypeController::class, 'store']);
    Route::get('/types/{id}', [TypeController::class, 'show']);
    Route::put('/types/{id}', [TypeController::class, 'update']);
    Route::delete('/types/{id}', [TypeController::class, 'destroy']);


    // AccountController  management
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/accounts', [AccountController::class, 'store']);
    Route::get('/accounts/{id}', [AccountController::class, 'show']);
    Route::put('/accounts/{id}', [AccountController::class, 'update']);
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy']);
    


    // AddressController  management
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses/{id}', [AddressController::class, 'show']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);


    // AttributeController  management
    Route::get('/attributes', [AttributeController::class, 'index']);
    Route::post('/attributes', [AttributeController::class, 'store']);
    Route::get('/attributes/{id}', [AttributeController::class, 'show']);
    Route::put('/attributes/{id}', [AttributeController::class, 'update']);
    Route::delete('/attributes/{id}', [AttributeController::class, 'destroy']);


    // CategoryController  management
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

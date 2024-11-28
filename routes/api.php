<?php

use App\Http\Controllers\Api\ArchivoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarpetaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ContactoController;
use App\Http\Controllers\Api\ContenidoController;
use App\Http\Controllers\Api\ExpoTokenController;
use App\Http\Controllers\Api\HijoController;
use App\Http\Controllers\Api\InfanteController;
use App\Http\Controllers\Api\LlamadaController;
use App\Http\Controllers\Api\LocalizacionController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\PlanTutorController;
use App\Http\Controllers\Api\TutorController;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/registerAdmin', [AuthController::class, 'registerAdmin']);
Route::post('/registerTutor', [AuthController::class, 'registerTutor']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'index']);
Route::get('/user-hijos', [HijoController::class, 'index']);
Route::post('/control', [HijoController::class, 'controlImagen']);

Route::post('/storageDoc', [HijoController::class, 'storageDocumento']);
Route::post('/storageDescarga', [HijoController::class, 'storageDescarga']);
Route::post('/storageFacebook', [HijoController::class, 'storageFacebook']);
Route::post('/storageTelegram', [HijoController::class, 'storageTelegram']);
Route::post('/storageUCC', [HijoController::class, 'storageUCC']);
Route::post('/storageContacto', [HijoController::class, 'storageContacto']);
Route::post('/storageUbicacion', [HijoController::class, 'storageUbicacion']);
Route::post('/storageCaptura', [HijoController::class, 'storageCaptura']);

Route::post('/register_token_boy', [ExpoTokenController::class, 'register_token']);
Route::post('/register-notification', [ExpoTokenController::class, 'registrarExpoToken']);
Route::post('/contenido', [ContenidoController::class, 'store']);
// Route::get('/contenido', [ContenidoController::class, 'index']);
// Route::post('/register-notification', [ExpoTokenController::class, 'registrarExpoToken']); //Registrar el expoToken al usuario
Route::get('/eliminar-token', [ExpoTokenController::class, 'eliminarExpoToken']);
//Eliminar el expotoken al usuario
Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/localizacion', [LocalizacionController::class, 'index']); //Para ver todas las localizaciones, sólo usuarios loggueados que sean administrador
    //Crud llamada
    Route::get('/llamada-contacto/{id}', [LlamadaController::class, 'llamadasContacto']);
    Route::post('/get_all_calls_from_child', [LlamadaController::class, 'get_all_calls_from_child']);
    Route::post('/llamada', [LlamadaController::class, 'store']);
    Route::put('/llamada/{id}', [LlamadaController::class, 'update']);
    Route::get('/llamada/{id}', [LlamadaController::class, 'show']);
    Route::delete('/llamada/{id}', [LlamadaController::class, 'destroy']);
    //Crud Categoria
    Route::get('/categoria', [CategoriaController::class, 'index']);
    Route::post('/categoria', [CategoriaController::class, 'store']);
    Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
    Route::get('/categoria/{id}', [CategoriaController::class, 'show']);
    Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);
    //Crud Contenido
    Route::get('/contenido', [ContenidoController::class, 'index']);
    Route::post('/quantity_of_content', [ContenidoController::class, 'quantity_of_content']);
    Route::put('/contenido/{id}', [ContenidoController::class, 'update']);
    Route::get('/contenido/{id}', [ContenidoController::class, 'show']);
    Route::delete('/contenido/{id}', [ContenidoController::class, 'destroy']);
    Route::post('/contenido-hijo', [ContenidoController::class, 'contenidoHijo']); //id del hijo, para ver el contenido que tiene un hijo en especifico, contenido que no es captura

    Route::post('/content_boy_capture', [ContenidoController::class, 'contentBoyCapture']); //id del hijo, para ver el contenido que tiene un hijo en especifico, contenido que es captura

    Route::get('/contenido-hijos', [ContenidoController::class, 'contenidoHijos']); //Muestra el contenido de cada hijo
    //Crud Contacto
    Route::post('/contacto-hijo', [ContactoController::class, 'hijoContactos']); //obtiene todos los contactos del hijo
    Route::get('/contacto/{id}', [ContactoController::class, 'show']);
    Route::post('/contacto', [ContactoController::class, 'store']);
    Route::put('/contacto/{id}', [ContactoController::class, 'update']);
    Route::delete('/contacto/{id}', [ContactoController::class, 'destroy']);
    //Crud PlanTutor
    Route::get('planes-tutor', [PlanTutorController::class, 'planTutor']);
    Route::get('plan-activo-tutor', [PlanTutorController::class, 'planActivo']);
    //Crud Archivo
    Route::post('/archivo', [ArchivoController::class, 'store']);
    Route::put('/archivo/{id}', [ArchivoController::class, 'update']);
    Route::get('/archivo/{id}', [ArchivoController::class, 'show']);
    Route::delete('/archivo/{id}', [ArchivoController::class, 'destroy']);
    Route::get('/archivo-hijo/{id}', [ArchivoController::class, 'archivoHijo']); //id del hijo, para ver el archivo que tiene un hijo en especifico
    //Route::get('/archivo-hijos', [ArchivoController::class, 'archivoHijos']);//Muestra el archivo de cada hijo

    //DATOS DEL USUARIO LOGGUEADO
    Route::post('/user', [AuthController::class, 'profile']);

    //METODOS PARA USUARIO LOGGUEADO TUTOR
    Route::post('/profileTutor', [AuthController::class, 'tutor']); //Para ver los datos del tutor loggueado
    Route::post('/hijos-tutor', [TutorController::class, 'hijosTutor']); //Para ver los hijos que tiene un tutor loggueado
    Route::post('/children-tutor', [TutorController::class, 'children_turor']); //Para ver los hijos que tiene un tutor loggueado
    Route::post('/registerHijo', [AuthController::class, 'registerHijo']); //Para que un tutor loggueado pueda registrar a un nuevo usuario hijo
    Route::put('tutor', [TutorController::class, 'update']); //Para actualizar los datos del tutor loggueado
    Route::delete('tutor', [TutorController::class, 'destroy']); //Para eliminar el usuario tutor loggueado
    Route::put('hijo-tutor/{id}', [HijoController::class, 'update']); //para actualizar los datos de un hijo del tutor
    Route::get('hijo-tutor/{id}', [HijoController::class, 'showHijo']); //para ver los datos de un hijo del tutor
    Route::delete('hijo-tutor/{id}', [HijoController::class, 'destroyHijo']); //Para eliminar un hijo de un usuario tutor loggueado
    Route::post('hijo-localizaciones', [HijoController::class, 'localizacionesHijo']); //para ver todas las localizaciones de un hijo
    Route::delete('hijo-localizacion/{id}', [LocalizacionController::class, 'destroy']); //id de la localización, elimina una localización de uno de sus hijos si lo encuentra
    //METODOS PARA USUARIO LOGGUEADO HIJO
    Route::post('/profileHijo', [AuthController::class, 'hijo']); //Para ver los datos del hijo loggueado
    Route::post('/tutor-hijo', [AuthController::class, 'tutorHijo']); //Para ver el tutor del hijo
    Route::post('/localizacion', [LocalizacionController::class, 'store']); //Para agregar localización al hijo
    //Registrar el expo-token al usuario

    /****PLAN *****/
    Route::apiResource('plan', PlanController::class);


    Route::put('update_perfil', [TutorController::class, 'update_perfil']); //Para actualizar los datos del tutor loggueado

    Route::post('/send_token', [ExpoTokenController::class, 'send_token']);
    Route::post('/store_boy', [HijoController::class, 'store_boy']);
    Route::post('/get_boy_not_register', [HijoController::class, 'get_boy_not_register']);
});

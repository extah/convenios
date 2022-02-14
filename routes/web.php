<?php

use App\Http\Middleware\SetDefaultTypeFilterForUrls;
use Illuminate\Support\Facades\Route;

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


// Auth::routes();

// Route::get('/ndo', 'NotificarController@index')
//     ->name('notificar.index');
Route::get('/','Inicio\InicioController@index');

Route::group(array('prefix' => 'inicio'), function(){
		Route::get('/',	'Inicio\InicioController@index')->name('inicio.index');
});

Route::group(array('prefix' => 'empleado'), function(){
	Route::post('/',	'empleado\EmpleadoController@home')->name('empleado.home');
	Route::get('/',	'empleado\EmpleadoController@indexget')->name('empleado.indexget');
	Route::get('/agregar',	'empleado\EmpleadoController@agregar')->name('empleado.agregarnuevoconvenio');
	Route::post('/agregarconvenio',	'empleado\EmpleadoController@agregarconvenio')->name('empleado.agregarconvenio');
	Route::post('/editarconvenio',	'empleado\EmpleadoController@editarconvenio')->name('empleado.editarconvenio');
	Route::post('/ejecucionconvenio',	'empleado\EmpleadoController@ejecucionconvenio')->name('empleado.ejecucionconvenio');
	Route::post('/ejecucionconveniocompra',	'empleado\EmpleadoController@ejecucionconveniocompra')->name('empleado.ejecucionconveniocompra');
	// Route::get('/descargar/{tipo}/{mes}/{anio}',	'empleado\EmpleadoController@descargarPDF')->name('empleado.descargarPDF');
	// Route::get('/mostrar/{tipo}/{mes}/{anio}',	'empleado\EmpleadoController@mostrarPDF')->name('empleado.mostrarPDF');
	// Route::post('/buscar',	'empleado\EmpleadoController@buscarPorMes')->name('empleado.buscarPorMes');
	Route::get('/buscarconvenios',	'empleado\EmpleadoController@buscarconvenios')->name('empleado.buscarconvenios');
	Route::post('/registrarse',	'empleado\EmpleadoController@registrarse')->name('empleado.registrarse');
	Route::get('/cerrarsesion',	'empleado\EmpleadoController@cerrarsesion')->name('empleado.cerrarsesion');
	Route::post('/tablaconvenios',	'empleado\EmpleadoController@tablaconvenios')->name('empleado.tablaconvenios');
	Route::get('/verconvenio/{id}',	'empleado\EmpleadoController@verconvenio')->name('empleado.verconvenio');
	Route::get('/verconvenio/{id}/{paso}',	'empleado\EmpleadoController@verconveniopaso')->name('empleado.verconveniopaso');
	Route::get('/verconvenio/{id}/{paso}/{pdf}',	'empleado\EmpleadoController@verpdfconvenio')->name('empleado.verpdfconvenio');

	Route::get('/prueba',	'empleado\EmpleadoController@prueba')->name('empleado.prueba');
});

Route::group(array('prefix' => 'recibodesueldo'), function(){
	Route::get('/',	'recibo\ReciboController@index')->name('recibo.index');

});


// BATCH EXCEL-EMMA

// Route::get('/importLotes','PiezaExcelController@importLotes')
//     ->name('piezaExcels.lotes');
// Route::post('/errorLotes', 'PiezaExcelController@errorLotes')
//     ->name('piezaExcels.errorLotes');
// Route::match(['get', 'post'], '/piezasExcel', 'PiezaExcelController@index')
//     ->name('piezaExcels.index');
// BATCH FIN
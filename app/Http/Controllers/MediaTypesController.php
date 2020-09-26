<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MediaType;

class MediaTypesController extends Controller
{
    public function showmass(){      
        //mostrar vista de carga masiva   
        return view("media-types.insert-mass");     
    } 
 
    public function storemass(Request $r){
        //Arreglos de mediatypes repetidos en BD
        $repetidos = [];
        //var_dump($r->file('media-types'));

        //reglas de validacion 
        $reglas =[
            'media-types' => 'required|mimes:csv,txt'
        ];

        //Crear validador
        $validador = Validator::make($r->all(), $reglas);

        //Validar
        if ($validador->fails()) {
            //return $validador->errors()->first('media-types');
            //enviar mensaje de error en la vista
            return redirect('mediatypes/insert')->withErrors($validador);
        }else{
            //Transladar el archivo cargado a Storage
            $r->file('media-types')->storeAs('media-types' , $r->file('media-types')->getClientOriginalName());

            //return "tipo valido";
            $ruta = base_path().'\storage\app\media-types\\'.$r->file('media-types')->getClientOriginalName();
            //abrir el archivo almacenado para lectura:
            if ( ($puntero = fopen($ruta , 'r')) !== false){
                $contadora=0;
                //Recorro cada linea del csv: fgetcsv, utilizando el puntero que representa el archivo
                while( ($linea = fgetcsv($puntero)) !== false) {

                    //Buscar el mediatype en $linea[0]
                    $conteo = MediaType::where('Name','=',$linea[0])->get()->count();

                    //si no hay registros en mediatype que se llamen igual.
                    if($conteo==0){
                        //crear objeto MediaType
                        $m = new MediaType();
                        //Asigno el nombre del media type
                        $m->Name = $linea[0];
                        //grabo en sqlite el nuevo media - type
                        $m->save();
                        //aumentar en 1 el contador
                        $contadora++;
                    }else {
                        //Hay registros del media type
                        //Agregar una casilla al arreglo repetidos
                        $repetidos[]=$linea[0];
                    }
                }
                //TODO: poner mensaje de grabación de carga masiva en la vista
                //Si hubo repetidos
                if (count($repetidos)==0) {
                    return redirect('mediatypes/insert')->with('exito',"Carga masiva realizada, Registros ingresados: $contadora");
                } else {
                    return redirect('mediatypes/insert')->with('error',"Carga masiva con las siguientes excepciones: ")->with("repetidos", $repetidos);
                }
                
                
            }
        }
    }
} 

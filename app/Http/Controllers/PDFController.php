<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Artista;

class PDFController extends Controller
{
    
    public function index(){
        //Crear el objeto
        $pdf = new Fpdf();
        
        //Añadir pagina
        $pdf ->AddPage();
        //Establecer punto (10,10) para comenzar
        $pdf->setXY(10,10);
        //tipo de letra
        $pdf->setFont('Arial','B',13);
        //Establecer contenido a mostrar 
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(220, 0, 255 );
        $pdf->SetDrawColor(0,0,0);
        $pdf->Cell(100,15,utf8_decode("NOMBRE ARTISTA"),1,0,"C",true);   
        $pdf->Cell(70,15,utf8_decode("NÚMERO DE ALBUNES"),1,1,"C",true);  
        
        //Recorrer el arreglo de artista para mostrar artista y albumnes
        $artistas = artista::all();
        $pdf->SetFillColor(122,115,115);
        $pdf->setFont('Arial','I',11);
        foreach($artistas as $a){
        $pdf->Cell(100,15,substr(utf8_decode($a->Name),0,50),1,0,"C",true);    
        $pdf->Cell(70,15,$a->albumes->count(),1,1,"L",true); 
        }

        //Utilizar objeto response
        $response = response($pdf ->Output());
        // definir el tipo mime
        $response->header("content-Type",'application/pdf');
        //retornar respuesta al navegador
        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Proposta;
use PDF;

class PdfController extends Controller
{
    public function geraPdfCliente($id){

        $cliente = Cliente::find($id);
        
        $pdf = PDF::loadView('pdf.pdfCliente',compact('cliente'));

        return $pdf->setPaper('a4')->stream('cliente.pdf');

    }

    public function geraPdfProposta($id){

        $proposta = Proposta::find($id);
        
        $pdf = PDF::loadView('pdf.pdfProposta',compact('proposta'));

        return $pdf->setPaper('a4')->stream('proposta.pdf');

    }
    

}

<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
    public function generateReport()
    {
        $bills = Bill::all();
        $pdf = PDF::loadView('reports.bills', compact('bills'));
        return $pdf->download('relatorio_de_contas.pdf');
    }
}
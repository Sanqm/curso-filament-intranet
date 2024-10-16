<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('personal');
});



Route::get('/pruebas/{user}', function () {
    $pdf = Pdf::loadView('pdf.invoice');
                return $pdf->download('invoice.pdf');
})->name('pdf.invoice');





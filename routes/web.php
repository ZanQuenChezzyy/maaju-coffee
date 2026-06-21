<?php

use App\Livewire\Pos;
use App\Livewire\QrMenu;
use App\Livewire\OrderTracking;
use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('login', fn() => redirect()->route('filament.admin.auth.login'))->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/pos', Pos::class)->name('pos');
    Route::get('/', function() {
        return redirect('/pos');
    });
});
Route::get('/table/{table}', QrMenu::class)->name('qr-menu');
Route::get('/order/{order}', OrderTracking::class)->name('order.track');

use App\Models\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/tables/{table}/print-qr', function(Table $table) {
    // Gunakan qr_code_url jika ada, jika tidak, otomatis buatkan URL ke halaman menu meja
    $url = $table->qr_code_url ?: route('qr-menu', ['table' => $table->id]);
    
    // Generate base64 QR Code (menggunakan format SVG agar tidak butuh ext-imagick)
    $qrCode = base64_encode(QrCode::format('svg')->size(400)->margin(1)->generate($url));

    $pdf = Pdf::loadView('pdf.table-qr', compact('table', 'qrCode'));
    return $pdf->stream('QR-Meja-'.$table->name.'.pdf');
})->name('table.print-qr');

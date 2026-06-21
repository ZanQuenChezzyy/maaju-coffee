<div wire:poll.3s="refreshOrder" class="min-h-screen font-sans relative overflow-hidden bg-slate-50 flex items-center justify-center p-4">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-300/30 blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-purple-300/30 blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Card -->
    <div class="relative z-10 w-full max-w-lg bg-white/70 backdrop-blur-2xl border border-white/80 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden">
        
        <!-- Header -->
        <div class="relative p-8 pb-6 text-center border-b border-white/50 bg-gradient-to-b from-white/60 to-transparent">
            @if($order->table)
                <a href="{{ route('qr-menu', ['table' => $order->table_id]) }}" class="absolute top-6 left-6 p-2 bg-white/80 rounded-full text-slate-600 hover:text-indigo-600 hover:bg-white shadow-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @endif
            <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-2 mt-4">Pelacakan Pesanan</h1>
            <p class="text-slate-500 font-medium">No. Pesanan: <span class="font-bold text-indigo-600">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></p>
            @if($order->table)
                <p class="text-sm font-bold bg-white/60 text-slate-700 px-4 py-1.5 rounded-full inline-block mt-3 border border-slate-200 shadow-sm">{{ $order->table->name }}</p>
            @endif
        </div>

        <div class="p-8">
            <!-- Order Status Pipeline -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Status Pesanan</h3>
                <div class="flex items-center justify-between relative">
                    <div class="absolute top-1/2 left-0 right-0 h-1 bg-slate-200 -translate-y-1/2 z-0 rounded-full"></div>
                    
                    @php
                        $statuses = [
                            'pending' => ['label' => 'Menunggu', 'icon' => '🕒'],
                            'cooking' => ['label' => 'Diproses', 'icon' => '🍳'],
                            'ready' => ['label' => 'Siap', 'icon' => '✨'],
                            'completed' => ['label' => 'Selesai', 'icon' => '✅'],
                        ];
                        
                        $currentIndex = array_search($order->status, array_keys($statuses));
                        if ($currentIndex === false) $currentIndex = 0;
                        $i = 0;
                    @endphp

                    @foreach($statuses as $key => $status)
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg font-bold border-2 transition-all shadow-sm
                                {{ $i < $currentIndex ? 'bg-indigo-600 border-indigo-600 text-white' : '' }}
                                {{ $i === $currentIndex ? 'bg-white border-indigo-500 text-indigo-600 shadow-indigo-200/50 scale-110' : '' }}
                                {{ $i > $currentIndex ? 'bg-slate-50 border-slate-200 text-slate-400 grayscale' : '' }}
                            ">
                                {{ $status['icon'] }}
                            </div>
                            <span class="text-[10px] sm:text-xs font-bold {{ $i <= $currentIndex ? 'text-slate-800' : 'text-slate-400' }}">{{ $status['label'] }}</span>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            </div>

            <!-- Payment Status & Upload -->
            <div class="bg-slate-50/50 rounded-2xl p-5 border border-white/60 mb-8 relative overflow-hidden">
                @if($order->payment_status === 'unpaid')
                    <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800">Status Pembayaran</h3>
                        <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Belum Lunas</span>
                    </div>

                    @if($order->transaction && $order->transaction->payment_method === 'transfer')
                        <!-- Informasi Rekening & QRIS -->
                        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-4 shadow-sm">
                            <h4 class="font-bold text-sm text-slate-800 mb-3 border-b pb-2">Informasi Pembayaran</h4>
                            
                            <div class="mb-4">
                                <p class="text-xs font-bold text-slate-500 mb-1">Transfer Bank</p>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 flex justify-between items-center mb-2">
                                    <div>
                                        <p class="font-black text-slate-800">BCA 1234567890</p>
                                        <p class="text-[10px] text-slate-500">a.n. Maaju Coffee</p>
                                    </div>
                                    <div class="text-2xl">🏦</div>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-slate-800">Mandiri 0987654321</p>
                                        <p class="text-[10px] text-slate-500">a.n. Maaju Coffee</p>
                                    </div>
                                    <div class="text-2xl">💳</div>
                                </div>
                            </div>

                            <div class="mb-2 text-center">
                                <p class="text-xs font-bold text-slate-500 mb-2">Atau Scan QRIS</p>
                                <div class="w-36 h-36 mx-auto bg-white rounded-xl border border-slate-200 p-2 flex items-center justify-center shadow-sm">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" class="w-full h-full opacity-90" alt="QRIS">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2">Scan dengan aplikasi M-Banking atau E-Wallet Anda</p>
                            </div>
                        </div>
                    @elseif($order->transaction && $order->transaction->payment_method === 'cash')
                        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-4 shadow-sm text-center">
                            <h4 class="font-bold text-sm text-slate-800 mb-2">Pembayaran Tunai (Kasir)</h4>
                            <p class="text-xs text-slate-600">Silakan menuju ke meja kasir dan beritahu nomor pesanan Anda untuk membayar dengan uang tunai.</p>
                        </div>
                    @endif

                    <p class="text-sm text-slate-600 mb-4 bg-red-50/50 p-3 rounded-xl border border-red-100 font-medium">⚠️ Pesanan Anda akan diproses setelah Anda menyelesaikan pembayaran atau mengunggah bukti transfer.</p>
                    
                    @if(session()->has('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm font-bold shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($order->transaction && $order->transaction->payment_receipt)
                        <div class="text-center p-4 bg-white/60 rounded-xl border border-white/80 shadow-sm">
                            <p class="text-sm font-bold text-slate-700 mb-2">✅ Bukti Transfer Sedang Diverifikasi</p>
                            <p class="text-xs text-slate-500">Mohon tunggu kasir memvalidasi pembayaran Anda.</p>
                        </div>
                    @else
                        <form wire:submit="uploadReceipt" class="flex flex-col gap-3">
                            <label class="block cursor-pointer relative border-2 border-dashed border-indigo-200 rounded-2xl p-6 hover:bg-indigo-50/50 transition-colors group text-center bg-white/50 overflow-hidden">
                                <!-- Loading State -->
                                <div wire:loading.flex wire:target="receiptImage" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 flex-col items-center justify-center">
                                    <svg class="animate-spin w-8 h-8 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span class="text-xs font-bold text-indigo-800">Mempersiapkan...</span>
                                </div>

                                @if($receiptImage)
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center shadow-sm">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <span class="text-sm font-bold text-emerald-700">Foto Siap Dikirim!</span>
                                        <span class="text-[10px] font-medium text-slate-400">Tap area ini jika ingin mengganti foto</span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                                            <svg class="w-6 h-6 text-indigo-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition-colors">Tap untuk Pilih Foto Bukti</span>
                                        <span class="text-[10px] font-medium text-slate-400">Bisa ambil dari Galeri atau Kamera</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="receiptImage" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"/>
                            </label>
                            @error('receiptImage') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            
                            <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md active:scale-95 text-sm flex justify-center items-center gap-2 disabled:opacity-50">
                                <span wire:loading.remove wire:target="uploadReceipt">Kirim Bukti Transfer</span>
                                <span wire:loading wire:target="uploadReceipt">Mengunggah...</span>
                            </button>
                        </form>
                    @endif
                @else
                    <div class="absolute top-0 left-0 w-1 h-full bg-green-500"></div>
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Status Pembayaran</h3>
                        <span class="bg-green-100 text-green-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Lunas</span>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Rincian Pesanan</h3>
                <ul class="space-y-3 mb-6">
                    @foreach($order->items as $item)
                        <li class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $item->menu->name ?? 'Menu Terhapus' }}</h4>
                                <p class="text-xs font-medium text-slate-500">{{ $item->quantity }}x @ Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-black text-slate-700 text-sm">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between items-end border-t border-slate-200 pt-4">
                    <span class="text-slate-500 font-bold text-sm">Total Tagihan</span>
                    <span class="text-2xl font-black text-slate-800 tracking-tight">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Action Button for Completed Orders -->
            @if($order->status === 'completed' && $order->table)
                <div class="mt-8 text-center border-t border-slate-200 pt-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600 mb-3 shadow-sm border border-green-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">Pesanan Anda Sudah Selesai!</h3>
                    <p class="text-xs text-slate-500 mb-5">Ingin memesan pencuci mulut atau minuman lain?</p>
                    <a href="{{ route('qr-menu', ['table' => $order->table_id]) }}" class="block w-full py-3.5 bg-slate-800 text-white font-bold rounded-xl shadow-lg hover:bg-slate-900 active:scale-95 transition-all">Pesan Menu Tambahan</a>
                </div>
            @endif

        </div>
        
        <div class="bg-slate-900 text-white text-center py-4 text-xs font-medium">
            Maaju Coffee &copy; {{ date('Y') }}. Segarkan halaman untuk pembaruan status.
        </div>
    </div>
</div>

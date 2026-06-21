<div class="min-h-screen bg-slate-50 pb-36 font-sans text-slate-800">
    <!-- Header with Glassmorphism -->
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl shadow-sm border-b border-slate-100">
        <div class="px-5 py-5 max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Selamat datang di</p>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Maaju Coffee</h1>
                </div>
                <div class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-3 py-1.5 rounded-xl font-bold text-sm shadow-sm">
                {{ $table->name }}
                </div>
            </div>
            
            <div class="flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kopi atau cemilan..." class="w-full pl-10 pr-4 py-3 bg-slate-100 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-sm font-medium">
                </div>
                <div class="relative">
                    <select wire:model.live="categoryId" class="appearance-none pl-4 pr-10 py-3 bg-slate-100 border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-sm font-bold text-slate-700 cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        @if(count($activeOrders) > 0)
            <!-- Active Orders Horizontal Scroll -->
            <div class="px-5 pb-4 max-w-2xl mx-auto flex overflow-x-auto snap-x hide-scrollbar gap-3">
                @foreach($activeOrders as $index => $activeOrder)
                    <a href="{{ route('order.track', $activeOrder->id) }}" class="snap-start shrink-0 flex items-center gap-3 px-4 py-2.5 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm hover:bg-indigo-100 transition-colors active:scale-95">
                        <div class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold text-indigo-900 leading-tight tracking-wide">Pesanan #{{ $index + 1 }}</p>
                            <p class="text-[10px] font-medium text-indigo-600">Rp{{ number_format($activeOrder->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <svg class="w-4 h-4 text-indigo-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @endforeach
            </div>
        @endif
    </header>

    <main class="max-w-2xl mx-auto mt-6 space-y-8 px-5">
        @if(session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-center font-semibold shadow-sm animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <!-- Recommendations (Apriori) -->
        @if(count($recommendations) > 0)
            <div class="mb-10 relative">
                <!-- Background decorative element -->
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-amber-300/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center justify-between mb-5 px-1 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-10 h-10 bg-gradient-to-tr from-amber-400 to-orange-500 rounded-xl shadow-lg shadow-orange-500/30 transform rotate-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">Paling Diminati</h2>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Cocok Untuk Anda</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-5 overflow-x-auto pb-8 pt-2 snap-x scroll-px-5 hide-scrollbar -mx-5 px-5 relative z-10">
                    @foreach($recommendations as $rec)
                        <div class="min-w-[260px] snap-start relative group">
                            <!-- Backdrop blur for liquid glass effect -->
                            <div class="absolute inset-0 bg-white/40 backdrop-blur-xl border border-white/80 rounded-[2rem] shadow-[0_10px_40px_-10px_rgba(0,0,0,0.08)] transition-all duration-500 group-hover:shadow-[0_20px_50px_-10px_rgba(79,70,229,0.2)] group-hover:bg-white/60"></div>
                            
                            <!-- Animated Glow -->
                            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-indigo-500/40 transition-all duration-500"></div>

                            <div class="relative z-10 p-5 flex items-center gap-4">
                                <!-- Image Container -->
                                <div class="relative w-20 h-20 shrink-0">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-2xl transform rotate-6 group-hover:rotate-12 transition-transform duration-500 opacity-40 blur-md"></div>
                                    @if($rec->image)
                                        <img src="{{ Storage::url($rec->image) }}" class="relative w-full h-full object-cover rounded-2xl border-2 border-white shadow-sm transform group-hover:scale-105 transition-transform duration-500" alt="{{ $rec->name }}">
                                    @else
                                        <div class="relative w-full h-full bg-slate-200 rounded-2xl border-2 border-white shadow-sm flex items-center justify-center transform group-hover:scale-105 transition-transform duration-500">
                                            <span class="text-2xl">☕</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Text Content -->
                                <div class="flex-1">
                                    <h3 class="font-black text-slate-800 text-sm leading-tight mb-1.5 line-clamp-2">{{ $rec->name }}</h3>
                                    <p class="text-indigo-600 font-extrabold text-sm mb-3">Rp{{ number_format($rec->price, 0, ',', '.') }}</p>
                                    
                                    <button wire:click="addToCart({{ $rec->id }})" class="w-full py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl shadow-md hover:bg-indigo-600 active:scale-95 transition-all flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        <span>Tambah</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Menu Grid -->
        <div class="pt-4 border-t border-slate-200">
            <h2 class="text-xl font-extrabold text-slate-900 mb-4 px-1">Menu Kami</h2>
            <div class="grid grid-cols-2 gap-4 sm:gap-6">
                @foreach($menus as $menu)
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group transition-all duration-500 hover:shadow-[0_20px_40px_-15px_rgba(79,70,229,0.15)] hover:-translate-y-2 relative">
                        <!-- Image Area -->
                        <div class="relative aspect-square sm:aspect-[4/3] bg-slate-100 overflow-hidden">
                            @if($menu->image)
                                <img src="{{ Storage::url($menu->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $menu->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content Area -->
                        <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between bg-white relative">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base leading-tight mb-1">{{ $menu->name }}</h3>
                                <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed mb-3">{{ $menu->description }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mt-auto">
                                <span class="text-indigo-600 font-black text-lg tracking-tight">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                                
                                @if(isset($cart[$menu->id]))
                                    <div class="flex items-center gap-2 bg-slate-100 rounded-full p-1 w-full sm:w-auto justify-between sm:justify-start">
                                        <button wire:click="removeFromCart({{ $menu->id }})" class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center font-bold text-slate-600 hover:text-red-500 active:scale-90 transition-transform">-</button>
                                        <span class="font-bold text-sm w-4 text-center">{{ $cart[$menu->id]['quantity'] }}</span>
                                        <button wire:click="addToCart({{ $menu->id }})" class="w-8 h-8 rounded-full bg-indigo-600 text-white shadow-sm shadow-indigo-200 flex items-center justify-center font-bold hover:bg-indigo-700 active:scale-90 transition-transform">+</button>
                                    </div>
                                @else
                                    <button wire:click="addToCart({{ $menu->id }})" class="w-full sm:w-auto px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 active:scale-95 transition-all shadow-sm">
                                        Tambah
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Floating Cart & Checkout Button -->
    @if(count($cart) > 0)
        <div wire:transition class="fixed bottom-6 left-0 right-0 z-40 px-5 flex justify-center pointer-events-none">
            <div class="pointer-events-auto w-full max-w-lg bg-slate-900 text-white rounded-3xl p-2 pl-6 shadow-2xl shadow-indigo-900/20 flex justify-between items-center transform transition-all duration-300 hover:-translate-y-1 hover:shadow-indigo-900/40">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="bg-indigo-500/20 text-indigo-300 text-xs font-black px-2 py-0.5 rounded-lg border border-indigo-500/30">{{ collect($cart)->sum('quantity') }} Item</span>
                    </div>
                    @php $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']); @endphp
                    <p class="text-lg font-black mt-1">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <button wire:click="openCartModal" class="px-6 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-2xl shadow-lg active:scale-95 transition-all flex items-center gap-2">
                    <span>Lihat Keranjang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Cart Review Modal -->
    @if($showCartModal)
    <div wire:transition class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-t-[2rem] sm:rounded-3xl shadow-2xl flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white/90 backdrop-blur-xl z-10 rounded-t-[2rem] sm:rounded-3xl">
                <h3 class="text-xl font-black text-slate-800 tracking-tight">Keranjang Pesanan</h3>
                <button wire:click="closeCartModal" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                @foreach($cart as $item)
                <div class="flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $item['name'] }}</h4>
                        <p class="text-indigo-600 font-bold text-sm">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl p-1 shadow-sm">
                        <button wire:click="removeFromCart({{ $item['id'] }})" class="w-8 h-8 rounded-xl bg-white text-slate-600 font-black shadow-sm flex items-center justify-center hover:text-red-500 hover:bg-red-50 active:scale-95 transition-all">
                            -
                        </button>
                        <span class="font-black text-sm w-4 text-center text-slate-800">{{ $item['quantity'] }}</span>
                        <button wire:click="addToCart({{ $item['id'] }})" class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-black shadow-sm flex items-center justify-center hover:bg-indigo-700 active:scale-95 transition-all">
                            +
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-slate-100 bg-slate-50 rounded-b-[2rem] sm:rounded-3xl sticky bottom-0 z-10">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-slate-500 font-semibold text-sm">Total Pembayaran</span>
                    @php $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']); @endphp
                    <span class="text-2xl font-black text-indigo-900 tracking-tight">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <button wire:click="openPaymentModal" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 active:scale-95 transition-all text-base tracking-wide flex items-center justify-center gap-2">
                    Lanjut Pembayaran
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Method Modal -->
    @if($showPaymentModal)
    <div wire:transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-xl font-black text-slate-800 text-center">Metode Pembayaran</h3>
                <p class="text-center text-xs text-slate-500 mt-1">Pilih cara Anda membayar pesanan ini</p>
            </div>
            <div class="p-4 space-y-3">
                <button wire:click="selectPaymentMethod('cash')" class="w-full flex items-center p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-500 hover:bg-indigo-50 transition-all text-left group">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-xl">💵</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Bayar di Kasir (Tunai)</h4>
                        <p class="text-[10px] text-slate-500 mt-0.5">Bayar langsung ke kasir dengan uang tunai</p>
                    </div>
                </button>
                <button wire:click="selectPaymentMethod('transfer')" class="w-full flex items-center p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-500 hover:bg-indigo-50 transition-all text-left group">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-xl">💳</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Transfer Bank / E-Wallet</h4>
                        <p class="text-[10px] text-slate-500 mt-0.5">BCA, Mandiri, OVO, GoPay, Dana</p>
                    </div>
                </button>
            </div>
            <div class="p-4 border-t border-slate-100">
                <button wire:click="cancelCheckout" class="w-full py-3 font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-all">Batal</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Confirmation Modal -->
    @if($showConfirmationModal)
    <div wire:transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all text-center p-8">
            <div class="p-6 text-center">
                <div class="w-20 h-20 mx-auto bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Yakin Ingin Memesan?</h3>
                <p class="text-sm text-slate-500 mb-6">Pesanan Anda akan segera disiapkan oleh dapur. Pastikan pesanan sudah sesuai ya.</p>
                
                <div class="flex gap-3">
                    <button wire:click="cancelCheckout" class="flex-1 py-3.5 font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Kembali</button>
                    <button wire:click="confirmOrder" wire:loading.attr="disabled" class="flex-1 py-3.5 font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-200 transition-all disabled:opacity-50">
                        <span wire:loading.remove wire:target="confirmOrder">Ya, Pesan!</span>
                        <span wire:loading wire:target="confirmOrder">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>

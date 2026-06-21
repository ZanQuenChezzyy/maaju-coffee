<div x-data="{ mobileCartOpen: false, burgerOpen: false }" class="flex flex-col lg:flex-row h-screen font-sans relative overflow-hidden bg-slate-50">
    <!-- Animated Gradient Background (Liquid Glass 2026 Aesthetic) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-300/30 blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-300/30 blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-teal-200/30 blur-[80px] animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Content (Menus) -->
    <div class="flex-1 flex flex-col overflow-hidden relative z-10 lg:pr-[400px]">
        <!-- Glass Header -->
        <header class="bg-white/60 backdrop-blur-2xl border-b border-white/80 shadow-[0_4px_30px_rgba(0,0,0,0.03)] px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sticky top-0 z-30">
            <div class="flex justify-between items-center w-full sm:w-auto">
                <div class="flex items-center gap-3">
                    <!-- Burger Navigation -->
                    <div class="relative">
                        <button @click="burgerOpen = !burgerOpen" @click.away="burgerOpen = false" class="p-2 sm:p-2.5 rounded-xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm hover:bg-white/80 transition-all text-slate-700 active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        
                        <!-- Burger Dropdown Menu -->
                        <div x-show="burgerOpen" x-transition.origin.top.left style="display: none;" class="absolute top-12 sm:top-14 left-0 w-56 bg-white/90 backdrop-blur-3xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl py-2 z-50">
                            <a href="/admin" class="flex items-center gap-3 px-5 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard Admin
                            </a>
                            <a href="/" class="flex items-center gap-3 px-5 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Segarkan Halaman
                            </a>
                        </div>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Maaju POS</h1>
                </div>
            </div>

            <div class="flex flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:min-w-[200px]">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari menu..." class="w-full pl-10 pr-4 py-2.5 bg-white/50 backdrop-blur-md border border-white/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/80 shadow-sm transition-all text-sm font-medium">
                    <svg class="w-4 h-4 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select wire:model.live="categoryId" class="px-4 py-2.5 bg-white/50 backdrop-blur-md border border-white/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/80 shadow-sm transition-all text-sm font-bold text-slate-700 appearance-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </header>
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 pb-32">
            @if(session()->has('success'))
                <div class="mb-6 bg-emerald-500/10 backdrop-blur-xl border border-emerald-500/20 text-emerald-700 p-4 rounded-2xl shadow-sm flex items-center gap-3">
                    <div class="bg-emerald-500 p-1.5 rounded-full text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach($menus as $menu)
                    <div class="bg-white/40 backdrop-blur-xl border border-white/60 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(99,102,241,0.15)] cursor-pointer hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col group relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-white/80 to-transparent z-0"></div>
                        @if($menu->image)
                            <img src="{{ Storage::url($menu->image) }}" class="w-full h-32 sm:h-40 object-cover relative z-10 group-hover:scale-105 transition-transform duration-500 rounded-t-[2rem]" alt="{{ $menu->name }}">
                        @else
                            <div class="w-full h-32 sm:h-40 bg-slate-200/50 backdrop-blur-md flex items-center justify-center text-slate-400 text-sm font-medium relative z-10 rounded-t-[2rem]">No Image</div>
                        @endif
                        <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between relative z-10 bg-white/60 backdrop-blur-2xl rounded-b-[2rem]">
                            <h3 class="font-bold text-slate-800 leading-tight text-sm sm:text-base">{{ $menu->name }}</h3>
                            <div class="flex justify-between items-center mt-3">
                                <p class="text-indigo-600 font-black text-sm sm:text-base">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                                <button wire:click="addToCart({{ $menu->id }})" class="w-8 h-8 rounded-full bg-white shadow-md text-indigo-600 font-bold hover:bg-indigo-600 hover:text-white transition-colors flex items-center justify-center active:scale-90 pb-0.5">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(count($recommendations) > 0)
                <div class="mt-10">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800 mb-4 px-1 flex items-center gap-2">
                        <span class="text-amber-500">✨</span> Sering Dibeli Bersamaan
                    </h2>
                    <div class="flex gap-4 overflow-x-auto pb-6 snap-x hide-scrollbar">
                        @foreach($recommendations as $rec)
                            <div class="min-w-[150px] sm:min-w-[180px] snap-start bg-gradient-to-br from-indigo-50/80 to-purple-50/80 backdrop-blur-xl border border-white/60 rounded-[2rem] p-4 cursor-pointer hover:bg-white/60 transition-all shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col items-center text-center group">
                                @if($rec->image)
                                    <img src="{{ Storage::url($rec->image) }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-full mb-3 shadow-md border-2 border-white group-hover:scale-110 transition-transform" alt="{{ $rec->name }}">
                                @endif
                                <h3 class="font-bold text-slate-800 text-sm sm:text-base mb-1">{{ $rec->name }}</h3>
                                <p class="text-indigo-600 font-black text-sm sm:text-base mb-3">Rp{{ number_format($rec->price, 0, ',', '.') }}</p>
                                <button wire:click="addToCart({{ $rec->id }})" class="text-xs sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl font-bold shadow-md shadow-indigo-200 transition-all active:scale-95 w-full">Tambah</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
    </div>

    <!-- Mobile Floating Cart Button -->
    <button @click="mobileCartOpen = true" class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-slate-900/90 backdrop-blur-xl text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 font-bold border border-slate-700 active:scale-95 transition-transform" style="{{ empty($cart) ? 'display: none;' : '' }}">
        <span class="bg-indigo-500 text-white text-xs px-2 py-0.5 rounded-full">{{ collect($cart)->sum('quantity') }}</span>
        <span>Lihat Pesanan</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
    </button>

    <!-- Sidebar (Cart) Liquid Glass -->
    <div :class="mobileCartOpen ? 'translate-y-0' : 'translate-y-full lg:translate-y-0'" 
         class="w-full lg:w-[400px] bg-white/70 backdrop-blur-3xl border-l border-white/60 shadow-[-10px_0_30px_rgba(0,0,0,0.05)] flex flex-col z-50 
                fixed lg:fixed lg:right-0 bottom-0 top-auto lg:top-0 h-[80vh] lg:h-screen transition-transform duration-500 rounded-t-[2.5rem] lg:rounded-none ease-[cubic-bezier(0.32,0.72,0,1)]">
        
        <!-- Handle for mobile swipe down (visual only here) -->
        <div class="lg:hidden flex justify-center pt-3 pb-1" @click="mobileCartOpen = false">
            <div class="w-12 h-1.5 bg-slate-300/50 rounded-full cursor-pointer"></div>
        </div>

        <div class="p-6 border-b border-white/40 flex justify-between items-center">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Pesanan Aktif</h2>
            <button @click="mobileCartOpen = false" class="lg:hidden w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold hover:bg-slate-200">×</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6">
            @if(empty($cart))
                <div class="text-center text-slate-400 mt-10">
                    <div class="w-20 h-20 bg-slate-100/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="font-bold text-slate-500">Keranjang masih kosong</p>
                    <p class="text-xs mt-1">Pilih menu di sebelah kiri</p>
                </div>
            @else
                <ul class="space-y-4">
                    @foreach($cart as $id => $item)
                        <li class="flex justify-between items-center bg-white/60 backdrop-blur-xl p-3 sm:p-4 rounded-[1.5rem] shadow-sm border border-white/80">
                            <div class="flex-1 pr-2">
                                <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $item['name'] }}</h4>
                                <p class="text-xs text-indigo-600 font-black mt-1">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-2 bg-slate-100/80 rounded-full p-1 border border-white/50 shadow-inner">
                                <button wire:click="removeFromCart({{ $id }})" class="w-8 h-8 rounded-full bg-white text-slate-600 shadow-sm flex items-center justify-center hover:text-red-500 font-black active:scale-90 transition-all">-</button>
                                <span class="font-bold w-4 text-center text-sm text-slate-700">{{ $item['quantity'] }}</span>
                                <button wire:click="addToCart({{ $id }})" class="w-8 h-8 rounded-full bg-indigo-600 text-white shadow-sm flex items-center justify-center hover:bg-indigo-700 font-black active:scale-90 transition-all">+</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="p-6 bg-white/80 backdrop-blur-2xl border-t border-white/60 shadow-[0_-10px_30px_rgba(0,0,0,0.03)] z-10 rounded-t-[2rem] lg:rounded-none">
            @php $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']); @endphp
            
            @if(count($cart) > 0)
                <div class="mb-5">
                    <p class="text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Metode Pembayaran</p>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="paymentMethod" value="cash" class="peer sr-only">
                            <div class="p-2.5 text-center rounded-xl border border-slate-200 bg-slate-50 text-slate-600 font-bold text-xs peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all shadow-sm active:scale-95">
                                Tunai (Cash)
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="paymentMethod" value="qris" class="peer sr-only">
                            <div class="p-2.5 text-center rounded-xl border border-slate-200 bg-slate-50 text-slate-600 font-bold text-xs peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all shadow-sm active:scale-95">
                                QRIS / EDC
                            </div>
                        </label>
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-end mb-6">
                <span class="text-slate-500 font-bold text-sm">Total Tagihan</span>
                <span class="text-2xl font-black text-slate-800 tracking-tight">Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <button wire:click="checkout" @if(empty($cart)) disabled @endif @click="mobileCartOpen = false" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-4 rounded-2xl transition-all shadow-xl shadow-slate-900/20 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none active:scale-[0.98] flex justify-center items-center gap-2">
                <span>Proses Transaksi</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </div>

    <!-- Backdrop for mobile cart -->
    <div x-show="mobileCartOpen" @click="mobileCartOpen = false" x-transition.opacity class="lg:hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40"></div>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>

<aside :class="{
        '-translate-x-full': !sidebarOpen,
        'translate-x-0': sidebarOpen
    }" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200
           transform transition-transform duration-300 shadow-lg
           md:translate-x-0 md:static md:shadow-none">

    <div class="flex flex-col w-full">

        <!-- Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div
                    class="h-9 w-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shadow">
                    I
                </div>
                <span class="text-base font-semibold text-slate-800">
                    IoTEcomm Admin
                </span>
            </div>

            <!-- Close (mobile) -->
            <button id="closeSidebar" @click="sidebarOpen = false"
                class="md:hidden rounded-lg p-2 text-slate-500 hover:bg-slate-100">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            <!-- Active -->
            <a href="{{ route('admin.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium 
                      @if(request()->routeIs('admin.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fas fa-chart-line @if(request()->routeIs('admin.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.analytics.map') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium 
                      @if(request()->routeIs('admin.analytics.map')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fas fa-map-marked-alt @if(request()->routeIs('admin.analytics.map')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                Customer Map
            </a>

            <!-- Normal -->
            <a href="{{ route('admin.categories.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.categories.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fa-solid fa-layer-group @if(request()->routeIs('admin.categories.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                หมวดหมู่
            </a>
            <!-- 
            <a href="{{ route('admin.brands.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.brands.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i class="fa-solid fa-copyright @if(request()->routeIs('admin.brands.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                แบรนด์
            </a> -->

            <a href="{{ route('admin.products.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.products.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fa-solid fa-palette @if(request()->routeIs('admin.products.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                สินค้า
            </a>

            <a href="{{ route('admin.locations.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.locations.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fas fa-map-marker-alt @if(request()->routeIs('admin.locations.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                สถานที่จัดเก็บ
            </a>

            <div class="my-4 border-t border-slate-100"></div>

            <a href="{{ route('admin.orders.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.orders.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fa-solid fa-cart-shopping @if(request()->routeIs('admin.orders.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                Orders
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
                      @if(request()->routeIs('admin.users.index')) bg-blue-50 text-blue-700 @else text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition  @endif">
                <i
                    class="fa-solid fa-users @if(request()->routeIs('admin.users.index')) text-blue-600 @else text-slate-400 group-hover:text-blue-600 @endif"></i>
                Users
            </a>

        </nav>

        <!-- Footer -->
        <div class="border-t border-slate-100 px-4 py-4 bg-slate-50">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">{{ auth()->guard('admin')->user()->name }}</p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>
            </div>
            <div>

                <form id="adminLogoutForm" action="{{ route("admin.logout") }}" method="post">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl
                       bg-blue-600 text-white px-3 py-2 text-sm font-medium
                       hover:bg-blue-700 transition shadow">
                        <i class="fas fa-sign-out-alt"></i>
                        ออกจากระบบ
                    </button>
                </form>
            </div>

        </div>

    </div>
</aside>
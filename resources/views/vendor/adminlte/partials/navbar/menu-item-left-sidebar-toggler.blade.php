<li class="nav-item">
    <!-- existing AdminLTE pushmenu toggler, enhanced to persist in localStorage for mobile -->
    <a id="sidebarToggleBtn" class="nav-link" data-widget="pushmenu" href="#"
        role="button"
        aria-label="{{ __('adminlte::adminlte.toggle_navigation') }}"
        @if(config('adminlte.sidebar_collapse_remember'))
            data-enable-remember="true"
        @endif
        @if(!config('adminlte.sidebar_collapse_remember_no_transition'))
            data-no-transition-after-reload="false"
        @endif
        @if(config('adminlte.sidebar_collapse_auto_size'))
            data-auto-collapse-size="{{ config('adminlte.sidebar_collapse_auto_size') }}"
        @endif>
        <i class="fas fa-bars"></i>
        <span class="sr-only">{{ __('adminlte::adminlte.toggle_navigation') }}</span>
    </a>
</li>

@once
    @push('js')
        <script>
            // Persist sidebar collapsed state in localStorage so mobile users can hide/show it
            (function(){
                const storageKey = 'proyectobarbe_sidebar_collapsed';
                const btn = document.getElementById('sidebarToggleBtn');
                if(!btn) return;

                // When AdminLTE's pushmenu toggler is clicked, wait a tick and store the state
                btn.addEventListener('click', function(ev){
                    // allow AdminLTE to toggle classes first
                    setTimeout(()=>{
                        const body = document.body;
                        const collapsed = body.classList.contains('sidebar-collapse') || body.classList.contains('sidebar-closed');
                        try { localStorage.setItem(storageKey, collapsed ? '1' : '0'); } catch(e) {}
                    }, 50);
                });

                // On load, apply stored preference if present. If none and screen is small, collapse sidebar by default.
                document.addEventListener('DOMContentLoaded', function(){
                    try{
                        const v = localStorage.getItem(storageKey);
                        const body = document.body;
                        if(v === null){
                            // No preference: on small screens collapse sidebar by default for better UX
                            if(window.innerWidth && window.innerWidth < 768){
                                if(!body.classList.contains('sidebar-collapse')) body.classList.add('sidebar-collapse');
                            }
                            return;
                        }
                        if(v === '1'){
                            if(!body.classList.contains('sidebar-collapse')) body.classList.add('sidebar-collapse');
                        } else {
                            body.classList.remove('sidebar-collapse');
                        }
                    }catch(e){ /* ignore storage errors */ }
                });
            })();
        </script>
    @endpush
@endonce
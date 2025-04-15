<script>
    // Initialize theme based on Flux settings or system preference
    function initializeTheme() {
        const fluxTheme = localStorage.getItem('flux_appearance') || 'system';
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (fluxTheme === 'dark' || (fluxTheme === 'system' && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    // Run immediately before page load
    initializeTheme();

    // Watch for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const fluxTheme = localStorage.getItem('flux_appearance') || 'system';
        if (fluxTheme === 'system') {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    });

    // Watch for Flux theme changes
    window.addEventListener('storage', (e) => {
        if (e.key === 'flux_appearance') {
            initializeTheme();
        }
    });

    // Ensure theme is applied after DOM content loads
    document.addEventListener('DOMContentLoaded', initializeTheme);
</script> 
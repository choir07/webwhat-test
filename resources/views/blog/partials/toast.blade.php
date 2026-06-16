<div id="toastContainer" class="fixed bottom-4 right-4 z-50 space-y-2">
    <!-- Toasts appear here -->
</div>

<script>
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    toast.className = `${colors[type]} text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <span>${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</span>
            <span>${message}</span>
        </div>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
        toast.classList.add('translate-x-0');
    }, 100);
    
    setTimeout(() => {
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};
</script>
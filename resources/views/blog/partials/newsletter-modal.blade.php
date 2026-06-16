<!-- Newsletter Modal -->
<div id="newsletterModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full mx-4 p-6 relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="text-5xl mb-4">📧</div>
            <h3 class="text-2xl font-bold mb-2">Subscribe to Newsletter</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Get the latest posts delivered right to your inbox!
            </p>
            
            <form id="newsletterForm" onsubmit="submitNewsletter(event)">
                @csrf
                <input type="text" name="name" placeholder="Your name (optional)" 
                       class="w-full border rounded-lg px-4 py-2 mb-3 dark:bg-gray-700 dark:border-gray-600">
                <input type="email" name="email" placeholder="Your email address" required
                       class="w-full border rounded-lg px-4 py-2 mb-4 dark:bg-gray-700 dark:border-gray-600">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                    Subscribe Now
                </button>
            </form>
            
            <p class="text-xs text-gray-500 mt-4">
                No spam, unsubscribe anytime.
            </p>
        </div>
    </div>
</div>

<div id="toastMessage" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg hidden z-50">
    <span id="toastText"></span>
</div>

<script>
function openModal() {
    document.getElementById('newsletterModal').classList.remove('hidden');
    document.getElementById('newsletterModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('newsletterModal').classList.add('hidden');
    document.getElementById('newsletterModal').classList.remove('flex');
}

function showToast(message, isError = false) {
    const toast = document.getElementById('toastMessage');
    const toastText = document.getElementById('toastText');
    toastText.textContent = message;
    toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
    toast.classList.add(isError ? 'bg-red-500' : 'bg-green-500');
    toast.classList.remove('hidden');
    
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

async function submitNewsletter(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch('/newsletter/subscribe', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message);
            form.reset();
            setTimeout(() => closeModal(), 2000);
        } else {
            showToast(data.message || 'Something went wrong', true);
        }
    } catch (error) {
        showToast('Network error. Please try again.', true);
    }
}

// Show modal after 10 seconds or on scroll
let modalShown = false;
setTimeout(() => {
    if (!modalShown && !localStorage.getItem('newsletter_shown')) {
        openModal();
        localStorage.setItem('newsletter_shown', 'true');
        modalShown = true;
    }
}, 10000);
</script>
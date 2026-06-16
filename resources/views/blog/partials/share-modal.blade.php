<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Share this post</h3>
            <button onclick="closeShareModal()" class="text-gray-500">✕</button>
        </div>
        
        <div class="grid grid-cols-2 gap-3 mb-4">
            <button onclick="shareTo('facebook')" 
                    class="bg-[#1877f2] text-white py-2 rounded-lg flex items-center justify-center space-x-2">
                <span></span><span>Facebook</span>
            </button>
            <button onclick="shareTo('twitter')" 
                    class="bg-[#1da1f2] text-white py-2 rounded-lg flex items-center justify-center space-x-2">
                <span></span><span>Twitter</span>
            </button>
            <button onclick="shareTo('linkedin')" 
                    class="bg-[#0077b5] text-white py-2 rounded-lg flex items-center justify-center space-x-2">
                <span></span><span>LinkedIn</span>
            </button>
            <button onclick="copyLink()" 
                    class="bg-gray-600 text-white py-2 rounded-lg flex items-center justify-center space-x-2">
                <span></span><span>Copy Link</span>
            </button>
        </div>
        
        <input type="text" id="shareUrl" value="{{ url()->current() }}" 
               class="w-full border rounded-lg px-3 py-2 text-sm dark:bg-gray-700" readonly>
    </div>
</div>

<script>
function openShareModal() {
    document.getElementById('shareModal').classList.remove('hidden');
    document.getElementById('shareModal').classList.add('flex');
}

function closeShareModal() {
    document.getElementById('shareModal').classList.add('hidden');
    document.getElementById('shareModal').classList.remove('flex');
}

function shareTo(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}`;
            break;
    }
    
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function copyLink() {
    const urlInput = document.getElementById('shareUrl');
    urlInput.select();
    document.execCommand('copy');
    showToast('Link copied to clipboard!');
    closeShareModal();
}
</script>
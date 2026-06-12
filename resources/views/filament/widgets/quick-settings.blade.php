<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Quick Settings</h3>
        <button wire:click="save" class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
            Save Changes
        </button>
    </div>
    
    <form wire:submit.prevent="save">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Theme</label>
                <select wire:model="data.theme" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                    <option value="system">System</option>
                </select>
            </div>
            
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Collapse Sidebar</label>
                <input type="checkbox" wire:model="data.sidebar_collapsed" class="rounded border-gray-300 text-amber-500">
            </div>
        </div>
    </form>
</div>
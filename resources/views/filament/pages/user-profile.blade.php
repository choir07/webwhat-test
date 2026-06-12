<x-filament-panels::page>
    <div class="max-w-2xl mx-auto">
        <form wire:submit="updateProfile" class="space-y-6">
            {{ $this->form }}
            
            <div class="flex justify-end gap-3">
                <x-filament::button type="submit" color="primary">
                    Save Changes
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
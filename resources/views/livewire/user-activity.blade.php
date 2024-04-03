<div class="flex items-center font-primary text-md">
    <div 
        class="h-2 5 w-2 rounded-full me-2 {{ $active->value === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></div>
    <p>{{ ucfirst($active->value) }}</p>
</div>
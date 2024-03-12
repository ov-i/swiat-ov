@props(['user'])

<div class="flex items-center">
    <div class="
        h-2.5 
        w-2.5 
        rounded-full 
        {{ $user->isBlocked() ? 'bg-red-500' : 'bg-green-500' }} me-2"></div> 
    {{ __($user->isBlocked() ? 'Yes' : 'No') }}
</div>
@component('mail:message')
    <h1 class="font-xl">{{ __('auth.block_header') }}</h1>
    <p>{{ __('auth.block_reason', ['reason', $user->block_reason]) }}</p>
@endcomponent
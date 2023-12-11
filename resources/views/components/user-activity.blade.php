@props(['activityService', 'user', 'commonStyles' => 'h-2.5 w-2.5 rounded-full me-2'])

<div class="flex items-center">
  @if ('active' === $activityService->getStatus($user))
    <div class="{{ $commonStyles }} bg-green-500" $attributes></div>
    {{ __('Active') }}
  @else
    <div class="{{ $commonStyles }} bg-red-500" $attributes></div>
    {{ __('Offline') }}
  @endif
</div>
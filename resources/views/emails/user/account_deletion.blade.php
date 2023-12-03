@component('mail::message')
  {{ __('Hi, :user. Your account has been deleted at :time.', ['user' => $user->name, 'time' => $user->deleted_at]) }}

  {{ __('If you want to restore your account, you can use button below.') }}
@endcomponent
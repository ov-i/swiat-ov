<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Users list') }}
    </h2>
  </x-slot>
        <x-validation-errors class="mb-4" />

  <div>/
    <form action="{{ route('tickets.store') }}" method="POST">
      @csrf

      <input type="text" name="title" placeholder="title">
      <textarea name="message" id="" cols="30" rows="10"></textarea>
      <button type="submit">Wyślij</button>      
    </form>
  </div>
</x-app-layout>
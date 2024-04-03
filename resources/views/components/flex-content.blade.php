@props(['actionClasses' => null])

<div {{ $attributes->merge(['class' => "outside-header flex flex-row justify-between w-full items-center"]) }}>
  <h1 class="text-lg md:text-xl lg:text-2xl font-primary text-gray-600 dark:text-zinc-300">
    {{ $header }}
  </h1>

  <div class="actions flex {{ $actionClasses }}">
    {{ $actions }}
  </div>
</div>
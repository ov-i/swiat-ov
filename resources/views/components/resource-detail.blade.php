 @props(['property', 'value', 'isLink' => false, 'to' => null, 'help' => null])
 <div {{ $attributes->merge(['class' => "resource-detail"]) }}>
    <div class="detail-property self-start font-light">
        <p class="text-md xl:text-base text-zinc-500 dark:text-white">
          {{ ucfirst($property) }}
        </p>
        @if($help)
          <span class="text-xs text-zinc-400">{{ __($help) }}</span>
        @endif
    </div>
    <div class="detail-value">
        @if($isLink)
          <a href="{{ $to }}" class="text-md text-blue-600 dark:text-blue-400">
            {{ $value ?? '-'}}
          </a>
        @else
          <p class="text-md xl:text-base text-zinc-600 dark:text-white">
            {{ $value ?? '-'}}
          </p>
        @endif
    </div>
</div>
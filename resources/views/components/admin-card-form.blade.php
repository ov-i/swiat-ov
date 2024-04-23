<section {{ $attributes->merge(['class' => 'flex flex-col space-y-2 mt-3 xl:flex-row xl:space-y-0 xl:space-x-5 xl:mt-0 items-start justify-between font-primary w-full']) }}>
  <section class="left-side-wrapper w-full">
    <section class="left-side w-full">
      {{ $formInputs }}
    </section>

    {{ $underInputs ?? null }}
  </section>

  @if(isset($rightSide))
    <div class="wrapper-main flex flex-row items-start w-full xl:w-2/3 justify-between font-secondary">
      <section class="right-side font-primary w-full flex flex-col xl:flex xl:items-end">
        {{ $rightSide }}
      </section>
    </div>
  @endif
</section>
   @props(['name', 'size' => 24])

   <svg width="{{ $size }}" height="{{ $size }}" {{ $attributes }}>
       <use href="{{ asset('icons/sprite.svg') }}#{{ $name }}"></use>
   </svg>
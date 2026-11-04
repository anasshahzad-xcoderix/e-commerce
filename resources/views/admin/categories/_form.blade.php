<link rel="stylesheet" href="{{ asset('css/products-form.css') }}">

<form method="POST" action="{{ $action }}" class="pf-form" novalidate>
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="pf-field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}">
        @error('name') <small class="pf-err">{{ $message }}</small> @enderror
    </div>

    <div class="pf-field">
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description') <small class="pf-err">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="pf-btn">{{ $submit ?? 'Save' }}</button>
</form>
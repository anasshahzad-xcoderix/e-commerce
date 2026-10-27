<form method="POST" action="{{ $action }}" class="cat-form" novalidate>
    @isset($method)
        @method($method)
    @endisset

    @csrf

    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}">
        @error('name') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description') <small class="err">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn-primary">{{ $submit ?? 'Save' }}</button>
</form>
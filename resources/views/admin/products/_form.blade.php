<form method="POST" action="{{ $action }}" class="admin-form" novalidate enctype="multipart/form-data">    @isset($method)
        @method($method)
    @endisset

    @csrf

    <div class="field">
        <label for="category_id">Collection</label>
        <select id="category_id" name="category_id" required>
            <option value="">-- Select Category --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="price">Price (Rs)</label>
        <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
        @error('price') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
        @error('stock') <small class="err">{{ $message }}</small> @enderror
    </div>

   <div class="field">
    <label for="image">Product image</label>

    <input type="file" id="image" name="image" accept="image/*">
    <small>Max 2 MB. JPG, PNG ya WEBP.</small>
    @error('image') <small class="err">{{ $message }}</small> @enderror

    <div class="img-preview-wrap">
        @if(isset($product) && $product->image)
            <p class="img-label">Current image</p>
            <img id="currentImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-preview">
        @endif

        <p class="img-label" id="newLabel" style="display:none;">New image (preview)</p>
        <img id="imagePreview" src="" alt="" class="img-preview" style="display:none;">
    </div>
</div>
 <div class="field">
        <label for="art">Icon (if there is no image)</label>
        <select id="art" name="art">
            @foreach(['basket','mug','vase','lamp','rug','bowl','plant','stool'] as $icon)
                <option value="{{ $icon }}" @selected(old('art', $product->art ?? 'mug') === $icon)>{{ ucfirst($icon) }}</option>
            @endforeach
        </select>
    </div>

   
    <button type="submit" class="btn-primary">{{ $submit ?? 'Save' }}</button>
</form>


<script>
(function () {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const newLabel = document.getElementById('newLabel');
    if (!input || !preview) return;

    input.addEventListener('change', function () {
        const file = input.files && input.files[0];
        if (!file) {
            preview.style.display = 'none';
            newLabel.style.display = 'none';
            preview.removeAttribute('src');
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        newLabel.style.display = 'block';
    });
})();
</script>




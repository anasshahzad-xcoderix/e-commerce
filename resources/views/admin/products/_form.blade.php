<link rel="stylesheet" href="{{ asset('css/products-form.css') }}">

@php $p = $product ?? null; @endphp




<form method="POST" action="{{ $action }}" class="pf-form" enctype="multipart/form-data" novalidate>
    @csrf
    @isset($method)
        @method($method)
    @endisset







    <div class="pf-field">
        <label for="category_id">Collection</label>
        <select id="category_id" name="category_id">
            <option value="">-- Select Category --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $p->category_id ?? null) == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id') <small class="pf-err">{{ $message }}</small> @enderror
    </div>





    <div class="pf-field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $p->name ?? '') }}">
        @error('name') <small class="pf-err">{{ $message }}</small> @enderror
    </div>




    <div class="pf-field">
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ old('description', $p->description ?? '') }}</textarea>
        @error('description') <small class="pf-err">{{ $message }}</small> @enderror
    </div>

    <div class="pf-field">
            <label for="price">Price (Rs)</label>
          <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $p->price ?? '') }}">
        @error('price') <small class="pf-err">{{ $message }}</small> @enderror
    </div>
    <div class="pf-field">
    <label for="compare_price">Old Price (optional)</label>
    <input type="number" id="compare_price" name="compare_price" step="0.01" min="0"
           value="{{ old('compare_price', $p->compare_price ?? '') }}">
    <small class="pf-hint">Leave blank if no sale is applicable.</small>
    @error('compare_price') <small class="pf-err">{{ $message }}</small> @enderror
</div>

          <div class="pf-field">
        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $p->stock ?? 0) }}">
        @error('stock') <small class="pf-err">{{ $message }}</small> @enderror
    </div>





        <div class="pf-field">
<label for="image">Product image</label>
          <input type="file" id="image" name="image" accept="image/*">
            <small class="pf-hint">Max 2 MB. JPG, PNG or WEBP.</small>
        @error('image') <small class="pf-err">{{ $message }}</small> @enderror
   




          <div class="pf-img-wrap">
            @if($p && $p->image)
                   <p class="pf-label-small">Current image</p>
                  <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="pf-img">
               @endif




                 <p class="pf-label-small" id="newLabel" style="display:none;">New image (preview)</p>
            <img id="imagePreview" src="" alt="" class="pf-img" style="display:none;">
        </div>
    </div>

  

    <button type="submit" class="pf-btn">{{ $submit ?? 'Save' }}</button>
</form>

<script>
(function () {
       const input = document.getElementById ('image');
       const preview = document.getElementById('imagePreview');
       const newLabel = document.getElementById('newLabel');
       if (!input) return;
          input.addEventListener('change', function () {
        const file = input.files && input.files[0]; 
              if (!file) {
                  preview.style.display = 'none';
                  newLabel.style.display = 'none';
                  return;
        }
             preview.src = URL.createObjectURL(file);
             preview.style.display = 'block';
                  newLabel.style.display = 'block';
    });
})();
</script>

<form method="POST" action="{{ $action }}" class="admin-form" novalidate enctype="multipart/form-data">    
    @if($errors->any())
    <div class="alert-err" style="background:#7f1d1d;color:#fecaca;padding:10px;border-radius:8px;margin-bottom:12px;">
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  
    @isset($method)
        @method($method)
    @endisset
    @csrf

    <div class="field">
        <label for="name">Name</label>
<input type="text" id="name" name="name" value="{{ old('name', $book->name ?? '') }}">        
@error('name') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description') <small class="err">{{ $message }}</small> @enderror
    </div>

    <div class="field">
       <label for="publish_date">Publish date</label>
<input type="date" id="publish_date" name="publish_date" value="{{ old('publish_date', isset($book) && $book->publish_date ? $book->publish_date->format('Y-m-d') : '') }}">
@error('publish_date') <small class="err">{{ $message }}</small> @enderror
    </div>
    <div class="field">
    <label for="image">Book image</label>
    @if(isset($book) && $book->image)
        <img src="{{ asset('storage/' . $book->image) }}" alt="" style="width:120px;height:120px;object-fit:cover;border-radius:10px;">
    @endif
    <input type="file" id="image" name="image" accept="image/*">
    @error('image') <small class="err">{{ $message }}</small> @enderror
</div>

    <button type="submit" class="btn-primary">{{ $submit ?? 'Save' }}</button>
</form>

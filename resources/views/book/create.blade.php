<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title') <div>{{ $message }}</div> @enderror
    </div>
    
    <div>
        <label>Author</label>
        <input type="text" name="author" value="{{ old('author') }}">
        @error('author') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Publish Date</label>
        <input type="date" name="publish_date" value="{{ old('publish_date') }}">
        @error('publish_date') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Book Image</label>
        <input type="file" name="image" accept="image/*">
        @error('image') <div>{{ $message }}</div> @enderror
    </div>

    <button type="submit">Add Book</button>
</form>
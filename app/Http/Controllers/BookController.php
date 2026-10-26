<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);

        $data['image'] = $request->file('image')->store('books', 'public');

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book is added.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Book is updated.');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book is deleted.');
    }

    private function validateData(Request $request, bool $imageRequired): array
    {
$imageRule = ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:20240';
        return $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'publish_date' => 'required|date',
            'image'        => $imageRule,
        ], [
            'name.required'         => 'Book name is required.',
            'description.required'  => 'Description is required.',
            'publish_date.required' => 'Publish date is reqired.',
            'publish_date.date'     => 'Publish date should be in right format.',
            'image.required'        => 'Book image is required.',
            'image.image'           => 'only image file should be uploaded.',
            'image.mimes'           => 'Image JPG, PNG ya WEBP should be.',
            'image.max'             => 'Image size should be in 10 MB .',
        ]);
    }
}
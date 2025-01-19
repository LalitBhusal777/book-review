<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $books = Book::when($keyword, function ($query, $keyword) {
            $query->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%');
        })->paginate(3);

        return view('books.list', compact('books', 'keyword'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author = $request->input('author');
        $book->status = $request->input('status');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book Added Successfully');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:5',
            'description' => 'required',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $book = Book::findOrFail($id);
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author = $request->input('author');
        $book->status = $request->input('status');

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (!empty($book->image) && File::exists(public_path('uploads/books/' . $book->image))) {
                File::delete(public_path('uploads/books/' . $book->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book Updated Successfully');
    }

    public function destroy(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer|exists:books,id', // Ensure the ID is valid
        ]);
    
        // Retrieve the book by ID
        $book = Book::find($request->id);
    
        if (!$book) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ], 404);
        }
    
        // Delete the book's image if it exists in the file system
        if ($book->image && File::exists(public_path('uploads/books/' . $book->image))) {
            File::delete(public_path('uploads/books/' . $book->image));
        }
    
        // Delete the book from the database
        $book->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Book deleted successfully',
        ]);
    }
    
}

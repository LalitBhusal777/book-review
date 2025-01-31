<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get the search keyword from the request
        $keyword = $request->input('keyword');

        // Query books with optional search and pagination
        $books = Book::query()
                     ->where('status', 1)
                     ->when($keyword, function ($query, $keyword) {
                         $query->where('title', 'like', '%' . $keyword . '%')
                               ->orWhere('author', 'like', '%' . $keyword . '%');
                     })
                     ->orderBy('created_at', 'DESC')
                     ->paginate(10);

        // Pass the keyword back to the view
        return view('home', compact('books', 'keyword'));
    }

    public function detail($id)
    {
        $book = Book::findOrFail($id);

        if ($book->status == 0) {
            abort(404);
        }

        $relatedBooks = Book::where('status', 1)
                            ->where('id', '!=', $id)
                            ->inRandomOrder()
                            ->take(3)
                            ->get();

        return view('book-detail', [
            'book' => $book,
            'relatedBooks' => $relatedBooks
        ]);
    }

   public function saveReview(Request $request)
{
    $validator = Validator::make($request->all(), [
        'book_id' => 'required|exists:books,id',
        'review'  => 'required|min:10',
        'rating'  => 'required|numeric|between:1,5'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed'
        ]);
    }

    $countReview = Review::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->count();
    if ($countReview > 0) {
        return response()->json([
            'status' => false,
            'message' => 'You have already reviewed this book'
        ]);
    }

    Review::create([
        'book_id' => $request->input('book_id'),
        'user_id' => Auth::id(),
        'review'  => $request->input('review'),
        'rating'  => $request->input('rating')
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Review submitted successfully'
    ]);
}
}

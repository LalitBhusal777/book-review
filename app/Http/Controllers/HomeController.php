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
        $keyword = $request->input('keyword');

        $books = Book::withCount('reviews')
                     ->withSum('reviews', 'rating')
                     ->where('status', 1)
                     ->when($keyword, function ($query, $keyword) {
                         $query->where('title', 'like', '%' . $keyword . '%')
                               ->orWhere('author', 'like', '%' . $keyword . '%');
                     })
                     ->orderBy('created_at', 'DESC')
                     ->paginate(10);

        return view('home', compact('books', 'keyword'));
    }

    public function detail($id)
    {
        $book = Book::with(['reviews.user', 'reviews' => function ($query) {
            $query->where('status', 1);
        }])
        ->withCount('reviews')
        ->withSum('reviews', 'rating')
        ->findOrFail($id);

        if ($book->status == 0) {
            abort(404);
        }

        $relatedBooks = Book::where('status', 1)
                            ->withSum('reviews', 'rating')
                            ->withCount('reviews')
                            ->where('id', '!=', $id)
                            ->inRandomOrder()
                            ->take(3)
                            ->get();

        return view('book-detail', compact('book', 'relatedBooks'));
    }

    public function saveReview(Request $request)
    {
        // Validate input fields
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'review'  => 'required|min:10',
            'rating'  => 'required|numeric|between:1,5'
        ]);
    
        // If validation fails, return JSON response
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }
    
        // Check if the user has already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('book_id', $request->book_id)
                                ->exists();
    
        if ($existingReview) {
            return response()->json([
                'status' => false,
                'message' => 'You have already reviewed this book'
            ], 400);
        }
    
        // Create and store the review
        Review::create([
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'review'  => $request->review,
            'rating'  => $request->rating
        ]);
    
        return response()->json([
            'status'  => true,
            'message' => 'Review submitted successfully'
        ]);
    }
}

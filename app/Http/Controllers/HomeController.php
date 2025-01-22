<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the search keyword from the request
        $keyword = $request->input('keyword');
    
        // Query books with optional search and pagination
        $books = Book::query()
                     ->orderBy('created_at', 'DESC')
                     ->where('status', 1)
                     ->when($keyword, function ($query, $keyword) {
                         $query->where('title', 'like', '%' . $keyword . '%')
                               ->orWhere('author', 'like', '%' . $keyword . '%');
                     })
                     ->paginate(10);
    
        // Pass the keyword back to the view
        return view('home', compact('books', 'keyword'));
    }    
}

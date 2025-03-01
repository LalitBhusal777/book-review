@extends('layouts.app')

@section('main')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h2 class="mb-3">Books</h2>
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm text-dark">Clear</a>
                </div>
            </div>

            <div class="card shadow-lg border-0">
                <form action="" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-11 col-md-11">
                                <input type="text" class="form-control form-control-lg" 
                                       value="{{ request()->get('keyword') }}" 
                                       name="keyword" placeholder="Search by title">
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <button class="btn btn-primary btn-lg w-100">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row mt-4">
                @if($books->isNotEmpty())
                    @foreach($books as $book)
                        @php
                            // Ensure valid rating calculation
                            $avgRating = $book->reviews_count > 0 ? ($book->reviews_sum_rating / $book->reviews_count) : 0;
                            $imagePath = 'uploads/books/thumb/' . $book->image;
                            $image = ($book->image && file_exists(public_path($imagePath))) 
                                     ? asset($imagePath) 
                                     : asset('images/default-book.jpg');
                        @endphp

                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card border-0 shadow-lg">
                                <a href="{{ auth()->check() ? route('book.detail', $book->id) : route('login') }}">
                                    <img src="{{ $image }}" alt="{{ $book->title }}" 
                                         class="card-img-top book-img"
                                         style="width: 100%; height: 350px; object-fit: cover;">
                                </a>

                                <div class="card-body">
                                    <h3 class="h4 heading">{{ $book->title }}</h3>
                                    <p>by {{ $book->author }}</p>

                                    {{-- Display Star Rating --}}
                                    <div class="star-rating d-inline-flex ml-2">
                                        <span class="rating-text theme-font theme-yellow">
                                            {{ number_format($avgRating, 1) }}
                                        </span>
                                        <div class="star-rating d-inline-flex mx-2">
                                            <div class="back-stars">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                @endfor
                                                <div class="front-stars" style="width: {{ $avgRating * 20 }}%">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <span class="theme-font text-muted">({{ $book->reviews_count }} Reviews)</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No books found.</p>
                @endif

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $books->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

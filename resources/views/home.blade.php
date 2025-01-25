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
                                <input type="text" class="form-control form-control-lg" value="{{Request::get('keyword')}}" name="keyword" placeholder="Search by title">
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
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card border-0 shadow-lg">
                        <a href="{{route('book.detail',$book->id)}}">
                        {{-- Image Display Logic --}}
                        <img src="{{ $book->image && file_exists(public_path('uploads/books/thumb/' . $book->image)) 
                                    ? asset('uploads/books/thumb/' . $book->image) 
                                    : asset('images/default-book.jpg') }}"
                            alt="{{ $book->title }}"
                            class="card-img-top book-img"
                            style="width: 100%; height: auto; max-width: 900px; max-height: 1300px; object-fit: cover;">
                            </a>

                        <div class="card-body">
                            <h3 class="h4 heading">{{ $book->title }}</h3>
                            <p>by {{ $book->author }}</p>
                            <div class="star-rating d-inline-flex ml-2" title="">
                                <span class="rating-text theme-font theme-yellow">
                                    {{ number_format($book->rating, 1) }}
                                </span>
                                <div class="star-rating d-inline-flex mx-2" title="">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <div class="front-stars" style="width: {{ $book->rating * 20 }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
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
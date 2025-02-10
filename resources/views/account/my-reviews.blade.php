@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome, John Doe
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="images/profile-img-1.jpg" class="img-fluid rounded-circle" alt="Luna John">
                    </div>
                    <div class="h5 text-center">
                        <strong>John Doe</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header  text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
        <div class="col-md-9">

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    My Reviews
                </div>
                <div class="card-body pb-0">
                <div class="d-flex justify-content-end">
                            <form action="{{ route('account.reviews') }}" method="get" class="d-flex">
                                <input type="search" name="keyword" value="{{ old('keyword', $keyword ?? '') }}" placeholder="Search" class="form-control" style="max-width: 250px;">
                                <button type="submit" class="btn btn-primary ms-2">Search</button>
                                <a href="{{ route('account.myReviews') }}" class="btn btn-secondary ms-2">Clear</a>
                            </form>
                        </div>  
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Book</th>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        <tbody>
                            @if($reviews->isNotEmpty())
                            @foreach($reviews as $review)
                            <tr>
                                <td>{{$review->book->title}}</td>
                                <td>{{$review->review}}</td>
                                <td>{{$review->rating}}</td>
                                <td>
                                    @if($review->status == 0)
                                    <span class="text-danger">Block</span>
                                    @elseif($review->status == 1)
                                    <span class="text-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="edit-review.html" class="btn btn-primary btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>

                        </thead>
                    </table>
                    {{$reviews->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
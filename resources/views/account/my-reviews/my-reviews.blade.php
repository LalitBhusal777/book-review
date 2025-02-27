@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome, {{ Auth::user()->name }}
                </div>
                <div class="text-center mb-3">
                                @if(auth()->user() && auth()->user()->image)
                                <img src="{{ asset('uploads/profile/' . auth()->user()->image) }}"
                                    class="img-fluid rounded-circle profile-img"
                                    alt="{{ auth()->user()->name }}">
                                @else
                                <img src="{{ asset('uploads/profile/default.png') }}"
                                    class="img-fluid rounded-circle profile-img"
                                    alt="Default Image">
                                @endif
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
                                    <a href="{{route('account.myReviews.editReview',$review->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="javascript:void(0);" onClick="deleteReview({{$review->id}})" class="btn btn-danger btn-sm">
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
@section('script')
<script type="text/javascript">
    function deleteReview(id) {
        if (confirm('Are you sure you want to delete this review?')) {
            $.ajax({
                type: 'DELETE', // Use DELETE method
                url: '{{ route("account.myReviews.deleteReview") }}',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.success); // Show success message
                    window.location.href = '{{ route("account.myReviews") }}'; // Redirect to review list
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error deleting review. Please try again.');
                }
            });
        }
    }
</script>
@endsection
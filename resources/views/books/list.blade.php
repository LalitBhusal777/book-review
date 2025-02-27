@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white">
                    Welcome, {{Auth::user()->name}}
                </div>
                <div class="card-body">
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
                    <div class="h5 text-center">
                        <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('books.index')}}">Books</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('account.myReviews')}}">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('account.profile')}}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('account.myReviews')}}">My Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="change-password.html">Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{'logout'}}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header text-white">
                    Books
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
                        <form action="{{ route('books.index') }}" method="get" class="d-flex">
                            <input
                                type="search"
                                name="keyword"
                                value="{{ old('keyword', $keyword ?? '') }}"
                                placeholder="Search"
                                class="form-control"
                                style="max-width: 250px;">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2">Clear</a>
                        </form>
                    </div>
                </div>



                <table class="table table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($books->isNotEmpty())
                        @foreach($books as $book)
                        <tr>
                            <td>{{$book->title}}</td>
                            <td>{{$book->author}}</td>
                            <td>3.0 (3 Reviews)</td>
                            <td>
                                @if($book->status == 1)
                                <span class="badge" style="background-color: #28a745; color: #fff;">Active</span>
                                @else
                                <span class="badge" style="background-color: #dc3545; color: #fff;">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <a href="#" class="btn btn-success btn-sm">
                                    <i class="fa-regular fa-star"></i>
                                </a>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="deleteBook({{ $book->id }});" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>


                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">No Books Found</td>
                        </tr>
                        @endif


                        <!-- Additional rows -->
                    </tbody>
                </table>
                @if($books->isNotEmpty())
                {{ $books->links() }}
                @endif

            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
   function deleteBook(id) {
    if (confirm('Are you sure you want to delete this book?')) {
        $.ajax({
            type: 'DELETE',
            url: "{{ route('books.destroy', ':id') }}".replace(':id', id),
            data: {
                _token: "{{ csrf_token() }}", // CSRF token for security
                id: id
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message || 'Book deleted successfully!');
                    // Optionally, remove the book row from the table
                    $("#book-" + id).remove();
                } else {
                    alert(response.message || 'Failed to delete the book.');
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'An error occurred while deleting the book.');
            }
        });
    }
}

</script>


@endsection
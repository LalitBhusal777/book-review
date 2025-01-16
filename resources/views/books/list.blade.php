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
                            <a href="reviews.html">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="profile.html">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="my-reviews.html">My Reviews</a>
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
                    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
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
                            <tr>
                                <td>Atomic Habits</td>
                                <td>James Clear</td>
                                <td>3.0 (3 Reviews)</td>
                                <td>Active</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                    <a href="edit-book.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <!-- Additional rows -->
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

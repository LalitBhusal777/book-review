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
                    <div class="card-header  text-white">
                        Add Book
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" placeholder="Title" name="title" id="title" />
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" placeholder="Author"  name="author" id="author"/>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control"  name="image" id="image"/>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Active</option>
                                <option value="">Block</option>
                            </select>
                        </div>


                        <button class="btn btn-primary mt-2">Create</button>                     
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection

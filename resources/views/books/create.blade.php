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
                    <div class="card-header  text-white">
                        Add Book
                    </div>
                    <div class="card-body">
                        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" value="{{old('title')}}" />
                            
                            
                            @error('title')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror


                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author"value="{{old('author')}}"/>
                            @error('author')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5" value="{{old('description')}}"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('author') is-invalid @enderror "  name="image" id="image"/>
                            @error('image')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                        </div>


                        <button class="btn btn-primary mt-2">Create</button>     
                        </form>                
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection

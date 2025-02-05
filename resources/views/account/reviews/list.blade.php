@extends('layouts.app')
@section('main')

  <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                   
                    <div class="card-body">
                    <div class="card border-0 shadow-lg">
                <div class="card-header text-white">
                    Welcome, {{ Auth::user()->name }}
                </div>
                <div class="card-body">
                    <!-- Profile Image -->
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

                    <!-- User Name and Reviews -->
                    <div class="h5 text-center">
                        <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Card -->
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                    @include('layouts.sidebar')
                </div>
            </div>
                    </div>
                </div>
                <div class="card border-0 shadow-lg mt-3">
                    <!-- <div class="card-header  text-white">
                        Navigation
                    </div> -->
                    <!-- <div class="card-body sidebar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="book-listing.html">Books</a>                               
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
                                <a href="login.html">Logout</a>
                            </li>                           
                        </ul>
                    </div> -->
                </div>                
            </div>
            <div class="col-md-9">
            @include('layouts.message')
                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0"> 
                    <div class="d-flex justify-content-end">
                        
                        <form action="{{ route('account.reviews') }}" method="get" class="d-flex">
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
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    
                                    <th>Review</th>
                                    <th>Book</th>
                                    <th>Rating</th>
                                    <th>Created At</th>
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if($reviews->isNotEmpty())
                                    @foreach($reviews as $review)
                                    <tr>
                                        
                                        <td>{{$review->review}}<br/><strong>{{$review->user->name}}</strong></td>   
                                        <td>{{$review->book->title}}</td>                                     
                                        <td>{{$review->rating}}</td>
                                        <td>
                                            {{\Carbon\Carbon::parse($review->created_at)->format('d M,Y')}}
                                        </td>
                                        <td>
                                            @if($review->status == 1)
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-danger">Block</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('account.reviews.edit',$review->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
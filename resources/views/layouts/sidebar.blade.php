<!-- <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
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
    </div> -->

<ul class="nav flex-column">
    @if(Auth::user()->role=='admin')
        <li class="nav-item">
                            <a href="{{route('books.index')}}">Books</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('account.reviews')}}">Reviews</a>
                        </li>
    
                        @endif
                        <li class="nav-item">
                            <a href="profile.html">Profile</a>
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
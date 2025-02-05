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

            </div>
        </div>
        <div class="col-md-9">

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    My Reviews
                </div>
                <div class="card-body pb-0">
                    <form action="{{ route('account.reviews.updateReview',$review->id) }}" method="POST">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Review</label>
                           <textarea name="review" class="form-control  @error('review') is-invalid @enderror" id="review">{{old('review',$review->review)}} </textarea>
                           @error('review')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1"{{($review->status==1)?'selected':''}}>Active</option>
                                <option value="0"{{($review->status==0)?'selected':''}}>Block</option>


                    
                            </select>
                            @error('status')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function register()
    {
        return view('account.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success', 'User created successfully');
    }

    public function login()
    {
        return view('account.login');
    }

    public function authinticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('account.profile')->with('success', 'You are logged in');
        }

        return redirect()->route('account.login')->with('error', 'Invalid credentials');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', [
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'image.required' => 'Please upload an image.',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'The image must be in one of the following formats: jpeg, png, jpg, gif.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('account.profile')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('uploads/profile'), $imageName);

            $user->image = $imageName;
            $user->save();
        }

        return redirect()->route('account.profile')->with('success', 'Profile image updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You are logged out');
    }

    public function myReviews(Request $request){
        
        $reviews = Review::with('book')->where('user_id', Auth::user()->id);
        $reviews=$reviews->OrderBy('Created_at','DESC');

        if(!empty($request->keyword))
        {
            $reviews=$reviews->where('review','like','%'.$request->keyword.'%');
            }

        $reviews=$reviews ->paginate(10);
        return view('account.my-reviews.my-reviews',[
    
        'reviews' => $reviews
    ]);
    }
    public function editReview($id){
        $review = Review::where([
     
            'id'=>$id,
            'user_id'=>Auth::user()->id
            ])->with('book')->first();

            return view('account.my-reviews.edit-review',[
    
                'review' => $review
            ]);

    }
    public function updateReview($id, Request $request){
        $review=Review::findorFail($id);
        $validator = Validator::make($request->all(),[
            'review'=>'required',
            'rating'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->route('account.Myreviews.editReview',$review->id)->withErrors($validator)->withInput();
    }
    $review->review=$request->review;
    $review->rating=$request->rating;
    $review->save();
    return redirect()->route('account.myReviews')->with('success','Review updated successfully');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    public function index(Request $request)
    {
        $reviews=Review::with('book','user')->orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $reviews=$reviews->where('review','like','%'.$request->keyword.'%');
        }
       


       $reviews=$reviews ->paginate(4);
        return view('account.reviews.list',[
           'reviews'=> $reviews
        ]);
        }
        public function edit($id){
            $review=Review::findorFail($id);
            return view('account.reviews.edit',[
                'review'=>$review
                ]);
        }
        public function updateReview($id, Request $request){
            $review=Review::findorFail($id);
            $validator = Validator::make($request->all(),[
                'review'=>'required',
                'status'=>'required',

            ]);
            if($validator->fails()){
                return redirect()->route('account.reviews.updateReview',$review->id)->withErrors($validator)->withInput();
        }
        $review->review=$request->review;
        $review->status=$request->status;
        $review->save();
        return redirect()->route('account.reviews')->with('success','Review updated successfully');
    }

    public function deleteReview(Request $request){
        $id=$request->id;
        $review=Review::findorFail($id);
        if($review==null){
            session()->flash('error','Review Not Found');
            return response()->json([ 
                'status' => false,
            ]);
            }else{
                $review->delete();
                session()->flash('success','Review deleted successfully');
                return response()->json([
                    'status' => true,
                    ]);
            }
        }
    }


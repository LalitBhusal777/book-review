<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //
    public function index()
    {
        return view('books.list');
    }
    public function create()
    {
        return view('books.create');

    }
    public function store(Request $request)
    {
        $rules=[
            'title'=>'required|min:5',
            'author'=>'required|min:3',
            'status'=>'required',
            
        ];
        if(!empty($request->image)){
            $rules['image']='required|image|mimes:jpeg,png,jpg,gif,
            svg|max:2048';


        }
        $validator= Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {
                    $book=new Book();
                    $book->title=$request->input('title');
                    $book->description=$request->input('description');
                    $book->author=$request->input('author');
                    $book->status=$request->input('status');
                    $book->save();
                    if(!empty($request->image)){
                        $image=$request->image;
                        $ext=$image->getClientOriginalExtension();
                        $imageName=time().'.'.$ext;
                        $image->move(public_path('uploads/books'),$imageName);
                        $book->image=$imageName;
                        $book->save();
                        }

                    return redirect()->route('books.index')->with('success','Book Added Successfully');
                    }
    }
    // public function show($id)
    // {
    //     }
    //     public function edit($id)
    //     {
    //         }
    //         public function update(Request $request, $id)
    //         {
    //             }
    //             public function destroy($id)
    //             {
    //                 }
                    
}

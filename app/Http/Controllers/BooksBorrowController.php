<?php

namespace App\Http\Controllers;

use App\Models\BooksBorrow;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;


class BooksBorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $borrowRecords = collect();
        $availableBooks = collect();

        if (auth()->user()->role === 'admin'){
            $borrowRecords = BooksBorrow::woth('user','book')->whereHas('book', function ($query) {$query->where('status','reserved');})->get();
        } else {
            $availableBooks = Book::where('status','available')->get();
        }

        return view('booksborrow.index', compact('borrowRecords','availableBooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booksBorrow = BooksBorrow::with('book')->where('user_id',$id)->get();

        if($booksBorrow->isEmpty()){
            return view('booksborrow.show',compact('booksBorrow'))->with('message','No borrowing records found');
        }

        return view('booksborrow.show',compact('booksBorrow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BooksBorrow $booksBorrow)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booksBorrow = BooksBorrow::findOrFail($id);

        $validatedData = $request->validate([
            'borrow_date'=>'required|date|after_or_equal:today',
            'return_date'=>'required|date|after_or_equal:borrow_date',
            'borrow_status'=>'required|string|in:borrowed,returned,overdue'
        ],[
            'borrow_date.after_or_equal'=>'The borrow date must be today or a future date.',
            'return_date.after_or_equal'=>'The return date must be after or the same as the borrow date.',
        ]);

        $booksBorrow->update($validatedData);

        if($validatedData ['borrow_status'] === 'returned'){
            $book = $booksBorrow->book;
            $book->update(['status'=> 'available']);
        }

        return redirect()->back('')->with('message','Borrowing record updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BooksBorrow $booksBorrow)
    {
        //
    }

    public function reserve(Request $request, Book $book){
        $validatedData = $request->validate([
            'user_id'=>'required|exists:users,id',
            'book_id'=>'required|exists:books,id',
            'status'=>'required|string',
        ]);

        $book->update(['status'=> $validatedData['status']]);

        BooksBorrow::create([
            'book_id'=>$validatedData['book_id'],
            'user_id'=>$validatedData['user_id'],
        ]);

        return redirect()->back()->with('message','The book has been reserved');
    }
}

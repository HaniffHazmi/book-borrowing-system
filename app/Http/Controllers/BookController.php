<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Validate the incoming request data
        $validated_data = $request->validate([
            'book_title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:13',
            'publisher' => 'required|string|max:255',
            'genre' => 'required|string|in:Fiction,Non-Fiction,Science Fiction,Biography',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $image_name = 'book_' . time() . '.' . $image->getClientOriginalExtension();
    
            // Set directory path and create directory if it doesn't exist
            $directory = public_path('uploads/books');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
    
            // Resize the image to 300x300 using GD
            $resized_image = imagecreatetruecolor(300, 300);
            $source_image = ($image->getClientOriginalExtension() == 'png') ?
                imagecreatefrompng($image->getRealPath()) :
                imagecreatefromjpeg($image->getRealPath());
    
            list($width, $height) = getimagesize($image->getRealPath());
            imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, 300, 300, $width, $height);
    
            // Save the image
            if ($image->getClientOriginalExtension() == 'png') {
                imagepng($resized_image, $directory . '/' . $image_name);
            } else {
                imagejpeg($resized_image, $directory . '/' . $image_name, 80); // 80 for JPEG quality
            }

             // Clean up resources
            imagedestroy($resized_image);
            imagedestroy($source_image);

            // Store the image path in the validated data
            $validated_data['photo'] = $image_name;

        }

        Book::create($validated_data);
        return redirect()->back()->with('message','Book added successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}

@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		Details of a Book
	</div>
	<div class="card-body">
		@if (session("message"))
		<div class="alert alert-success mt-3">
			<p>{{ session("message") }}</p>
		</div>
		@endif

			<table class="table">
				<tr>
					<td>Book Title</td>
					<td>
						<input type="text" name="book_title" value="{{ old('book_title', $book->book_title) }}" class="form-control">
						@error('book_title')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td>
						<input type="text" name="description" value="{{ old('description', $book->description) }}" class="form-control">
						@error('description')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Author</td>
					<td>
						<input type="text" name="author" value="{{ old('author', $book->author) }}" class="form-control">
						@error('author')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
        			<tr>
					<td>ISBN</td>
					<td>
						<input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="form-control">
						@error('isbn')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
        			<tr>
					<td>Publisher</td>
					<td>
						<input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="form-control">
						@error('publisher')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
        			<tr>
					<td>Genre</td>
					<td>
						<select name="genre" class="form-control">
							<option value="">-- Select Genre --</option>
							<option value="Fiction" {{ old('genre', $book->genre) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
							<option value="Non-Fiction" {{ old('genre', $book->genre) == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
							<option value="Science Fiction" {{ old('genre', $book->genre) == 'Science Fiction' ? 'selected' : '' }}>Science Fiction</option>
							<option value="Biography" {{ old('genre', $book->genre) == 'Biography' ? 'selected' : '' }}>Biography</option>
						</select>
						@error('genre')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Photo</td>
					<td>
						@if($book->photo)
						<img src="{{ asset('uploads/books/'.$book->photo) }}" style="width:300px; height:300px;" alt="Book Photo">
						@else
						No Photo Available
						@endif
					</td>
				</tr>
			</table>
	</div>
</div>
@endsection
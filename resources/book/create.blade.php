@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		Add a Book
	</div>
	<div class="card-body">
		@if (session("message"))
		<div class="alert alert-success mt-3">
			<p>{{ session("message") }}</p>
		</div>
		@endif


    	<form method="POST" action="" enctype="multipart/form-data">
		@csrf
			<table class="table">
				<tr>
					<td>Book Title</td>
					<td>
						<input type="text" name="book_title" value="{{ old('book_title') }}" class="form-control">
						@error('book_title')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td>
						<input type="text" name="description" value="{{ old('description') }}" class="form-control">
						@error('description')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Author</td>
					<td>
						<input type="text" name="author" value="{{ old('author') }}" class="form-control">
						@error('author')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
        			<tr>
					<td>ISBN</td>
					<td>
						<input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control">
						@error('isbn')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
        			<tr>
					<td>Publisher</td>
					<td>
						<input type="text" name="publisher" value="{{ old('publisher') }}" class="form-control">
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
							<option value="Fiction" {{ old('genre') == 'Fiction' ? 'selected' : '' }}>Fiction</option>
							<option value="Non-Fiction" {{ old('genre') == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
							<option value="Science Fiction" {{ old('genre') == 'Science Fiction' ? 'selected' : '' }}>Science Fiction</option>
							<option value="Biography" {{ old('genre') == 'Biography' ? 'selected' : '' }}>Biography</option>
						</select>
						@error('genre')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Photo</td>
					<td>
						<input type="file" name="photo" class="form-control">
						@error('photo')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" class="btn btn-primary">
							Submit
						</button>
					</td>
				</tr>
			</table>

		</form>

	</div>
</div>
@endsection
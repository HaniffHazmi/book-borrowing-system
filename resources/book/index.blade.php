@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of Books
	</div>
	<div class="card-body">

		@if (session("message"))
		<div class="alert alert-success mt-3">
			<p>{{ session("message") }}</p>
		</div>
		@endif
		
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Book Title</th>
				<th>Author</th>
				<th>Publisher</th>
				<th>Status</th>
                <th>Photo</th>
                <th>Action</th>
			</tr>
			@php($i = 0)
			@foreach($books as $book)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $book->book_title }}</td>
				<td>{{ $book->author }}</td>
				<td>{{ $book->publisher }}</td>
                <td>{{ $book->status }}</td>
                <td>
                    @if($book->photo)
                    <img src="{{ asset('uploads/books/'.$book->photo) }}" style="width:100px;">
                    @else
                    No Photo
                    @endif
                </td>
                <td class="text-center">
					@if(request('action') == 'update')
						<a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Update</a>
					@elseif(request('action') == 'delete')
						<form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger btn-sm">Delete</button>
						</form>
					@else
						<a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm">Details</a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		<!-- Pagination Links -->
        	<div class="d-flex justify-content-center">
            		{{ $books->appends(['action' => request('action')])->links() }}
        	</div>
	</div>
</div>
@endsection
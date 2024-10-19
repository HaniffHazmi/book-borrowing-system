@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        Details of Borrowed Books
    </div>
    <div class="card-body">
        @if (session("message"))
        <div class="alert alert-success mt-3">
            <p>{{ session("message") }}</p>
        </div>
        @endif

        @if($booksBorrow->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Borrow Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booksBorrow as $borrow)
                        <tr>
                            <td>{{ optional($borrow->book)->book_title ?? 'N/A' }}</td>
                            <td>{{ $borrow->borrow_date ?? 'Pending for approval' }}</td>
                            <td>{{ $borrow->return_date ?? 'Pending for approval' }}</td>
                            <td>{{ $borrow->borrow_status ?? 'Pending for approval' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No borrowing records found for you.</p>
        @endif
    </div>
</div>
@endsection
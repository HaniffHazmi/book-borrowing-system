@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        List of Borrowing
    </div>
    <div class="card-body">

        <!-- Display All Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display Success Message -->
        @if (session("message"))
            <div class="alert alert-success mt-3">
                <p>{{ session("message") }}</p>
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Name</th>
                    @endif
                    <th>Book Title</th>

                    @if(auth()->user()->role === 'user')
                        <th>Action</th>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php($i = 0)

                <!-- Admin View: Borrow Records -->
                @if(auth()->user()->role === 'admin')
                    @foreach($borrowRecords as $borrow)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $borrow->user->name }}</td>
                            <td>{{ $borrow->book->book_title }}</td>

                            <form method="POST" action="{{ route('booksborrow.update', $borrow->id) }}">
                                @csrf
                                @method('PATCH')

                                <!-- Borrow Date Input -->
                                <td>
                                    <input type="date" 
                                        name="borrow_date" 
                                        value="{{ old('borrow_date', $borrow->borrow_date) }}" 
                                        class="form-control borrow-date @error('borrow_date') is-invalid @enderror" 
                                        data-return-date="return_date_{{ $borrow->id }}">

                                    @error('borrow_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </td>

                                <!-- Return Date Input -->
                                <td>
                                    <input type="date" 
                                        name="return_date" 
                                        value="{{ old('return_date', $borrow->return_date) }}" 
                                        id="return_date_{{ $borrow->id }}" 
                                        class="form-control @error('return_date') is-invalid @enderror">

                                    @error('return_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </td>

                                <!-- Borrow Status Select -->
                                <td>
                                    <select name="borrow_status" class="form-select @error('borrow_status') is-invalid @enderror">
                                        <option value="">Please select the status</option>
                                        <option value="borrowed" 
                                            {{ old('borrow_status', $borrow->borrow_status) === 'borrowed' ? 'selected' : '' }}>
                                            Borrowed
                                        </option>
                                        <option value="returned" 
                                            {{ old('borrow_status', $borrow->borrow_status) === 'returned' ? 'selected' : '' }}>
                                            Returned
                                        </option>
                                        <option value="overdue" 
                                            {{ old('borrow_status', $borrow->borrow_status) === 'overdue' ? 'selected' : '' }}>
                                            Overdue
                                        </option>
                                    </select>

                                    @error('borrow_status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </td>

                                <!-- Update Button -->
                                <td class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </td>
                            </form> <!-- Close form -->
                        </tr>
                    @endforeach

                <!-- User View: Reserve Books -->
                @else
                    @foreach($availableBooks as $book)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $book->book_title }}</td>
                            <td>
                                <form action="{{ route('booksborrow.reserve', $book->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="status" value="reserved">
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                    <button type="submit" class="btn btn-primary btn-sm">Reserve</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript to Automatically Set Return Date -->
<script>
    document.querySelectorAll('.borrow-date').forEach(function (input) {
        input.addEventListener('change', function () {
            const returnDateId = this.getAttribute('data-return-date');
            const returnDateInput = document.getElementById(returnDateId);

            if (this.value) {
                const borrowDate = new Date(this.value);
                const returnDate = new Date(borrowDate);
                returnDate.setDate(borrowDate.getDate() + 14); // Add 14 days

                // Format the date as YYYY-MM-DD
                const year = returnDate.getFullYear();
                const month = String(returnDate.getMonth() + 1).padStart(2, '0');
                const day = String(returnDate.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;

                returnDateInput.value = formattedDate;
            }
        });
    });
</script>
@endsection
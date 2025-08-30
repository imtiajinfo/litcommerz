<h5>Reviews for: {{ $product->product_name }}</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->user->name ?? 'N/A' }}</td>
            <td>{{ $review->rating }}</td>
            <td>{{ $review->review }}</td>
            <td>
<form action="{{ route('admin.reviews.status.update', $review->id) }}" method="POST" style="display:inline;" class="form-load" type="create">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="0">
    <input type="checkbox" name="status" value="1" class="form-check-input toggle-status" {{ $review->status ? 'checked' : '' }}>
</form>


            </td>
        @endforeach
    </tbody>
</table>
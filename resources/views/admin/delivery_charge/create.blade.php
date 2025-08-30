<form class="form-load" type="create" action="{{ route('admin.delivery-charges.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="required">Region</label>
        <select class="form-control" name="region_id" required>
            <option value="">Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="required">City</label>
        <input type="text" class="form-control" name="city" placeholder="City Name" required>
    </div>
    <div class="form-group">
        <label class="required">Delivery Charge</label>
        <input type="number" step="0.01" class="form-control" name="charge" placeholder="Charge" required>
    </div>
    <x-admin.modal.create-btn />
</form>
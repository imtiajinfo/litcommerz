<form class="form-load" type="update" action="{{ route('admin.delivery-charges.update', $deliveryCharge->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="required">Region</label>
        <select class="form-control" name="region_id" required>
            <option value="">Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" {{ $deliveryCharge->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="required">City</label>
        <input type="text" class="form-control" name="city" value="{{ $deliveryCharge->city }}" placeholder="City Name" required>
    </div>
    <div class="form-group">
        <label class="required">Delivery Charge</label>
        <input type="number" step="0.01" class="form-control" name="charge" value="{{ $deliveryCharge->charge }}" placeholder="Charge" required>
    </div>
    <x-admin.modal.update-btn />
</form>

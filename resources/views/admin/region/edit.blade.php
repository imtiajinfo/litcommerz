@php
$setting = Helper::setting();
@endphp
<form class="form-load" type="update" action="{{ route('admin.regions.update', $region->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="required">Zone Name<span class="text-danger">*</span></label>
        <input type="text" class="form-control" value="{{ $region->name }}" name="name" required>
    </div>
    <div class="form-group">
        <label class="required">Delivery Charge ({{ $setting->currency_icon }})<span class="text-danger">*</span></label>
        <input type="number" class="form-control" value="{{ $region->delivery_charge }}" name="delivery_charge" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
    </div>
    <x-admin.modal.update-btn />
</form>
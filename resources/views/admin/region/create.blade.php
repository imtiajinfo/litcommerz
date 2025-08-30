<form class="form-load" type="create" action="{{ route('admin.regions.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="required">Zone Name<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" placeholder="" required>
    </div>
    <div class="form-group">
        <label class="required">Delivery Charge (¥)<span class="text-danger">*</span></label>
        <input type="number" class="form-control" name="delivery_charge" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
    </div>
    <x-admin.modal.create-btn />
</form>
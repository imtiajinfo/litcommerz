<form class="form-load" type="edit" action="{{ route('admin.user.role_update') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <div class="form-group">
        <label>Name<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>

    <div class="form-group mt-2">
        <label>Email<span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>

    <div class="form-group mt-2">
        <label>Password <small>(Leave blank to keep unchanged)</small></label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group mt-2">
        <label class="required">Role<span class="text-danger">*</span></label>
        <select class="form-control" name="role" required>
            <option value="">Select Role</option>
            @foreach ($roles as $item)
                <option value="{{ $item->id }}" {{ $user->role == $item->id ? 'selected' : '' }}>
                    {{ $item->role_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-2">
        <label>Status</label>
        <select name="status" class="form-control" id="status-select">
            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>Blocked</option>
        </select>
    </div>

    <div class="form-group mt-2" id="block-until-field" style="{{ $user->status == 2 ? '' : 'display: none;' }}">
        <label>Block Until</label>
        <input type="date" name="block_until" class="form-control" value="{{ $user->block_until }}">
    </div>

    <x-admin.modal.update-btn />
</form>

<script>
    document.getElementById('status-select').addEventListener('change', function () {
        const blockField = document.getElementById('block-until-field');
        this.value == '2' ? blockField.style.display = 'block' : blockField.style.display = 'none';
    });
</script>
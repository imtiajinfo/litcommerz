<form class="form-load" type="create" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Name<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group mt-2">
        <label>Email<span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group mt-2">
        <label>Password<span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group mt-2">
        <label>Role<span class="text-danger">*</span></label>
        <select name="role" class="form-control" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
            @endforeach
        </select>
    </div>

    <x-admin.modal.create-btn />
</form>
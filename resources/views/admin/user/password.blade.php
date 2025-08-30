<form class="form-load" type="create" action="{{ route('admin.user.change_password') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <div class="col-lg-12 col-sm-12 col-12">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>
    </div>
    <x-admin.modal.update-btn />
</form>
<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <form class="form-load pl-4" type="create" action="{{ route('my-profile.store') }}" method="POST">
                @csrf
                <h3 class="text-center">Password Change</h3>
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input name="old_password" type="password" class="form-control " placeholder="Old Password" value="">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input name="new_password" type="password" class="form-control " placeholder="New Password" value="">
                </div>
                <div class="form-group">
                    <label for="">Re-New Password</label>
                    <input name="re_password" type="password" class="form-control " placeholder="Re New Password" value="">
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-success me-2">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
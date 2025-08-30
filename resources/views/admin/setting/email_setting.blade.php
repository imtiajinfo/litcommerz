<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Mail Setting</h4>
            <h6>Manage Mail Setting</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="form-load" type="create" action="{{ route('admin.mailSetting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Driver</label>
                            <input value="{{@$mail->driver}}" name="driver" type="driver" class="form-control " placeholder="Driver">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Host</label>
                            <input value="{{@$mail->host}}" name="host" type="text" class="form-control " placeholder="Host">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Port</label>
                            <input value="{{@$mail->port}}" name="port" type="number" class="form-control" placeholder="Port">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Username</label>
                            <input value="{{@$mail->username}}" name="username" type="text" class="form-control" placeholder="Username Link">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Password</label>
                            <input value="{{@$mail->password}}" name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-group-sm">
                            <label for="">Encryption</label>
                            <input value="{{@$mail->encryption}}" name="encryption" type="text" class="form-control" placeholder="Encryption">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Update</button>
                    </div>
                    
                </div>
            </form>
            <form class="form-load" type="create" action="{{ route('admin.mailSetting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="1">
                    <div class="col-lg-12 justify-content-center d-flex">
                        <button type="submit" class="btn btn-success me-2 mt-2">Test Mail Configuration</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

</div>

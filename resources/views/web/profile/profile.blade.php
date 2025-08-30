<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <form class="form-load pr-4 input-group-sm" type="create" action="{{ route('my-profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">

                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="profile">
                        <h3 class="text-center">Profile Information</h3>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control input-group-sm" disabled value="{{$profile->email}}">
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control input-group-sm" name="name" placeholder="Name" value="{{$profile->name}}">
                        </div>
                    
                        <div class="form-group">
                            <img id="profileImage" style="height: 100px;width:auto" src="@if($profile->avatar){{asset('frontend/images/profile/'.$profile->avatar)}}@endif">
                            <input type="file" name="image" class="form-control" oninput="profileImage.src=window.URL.createObjectURL(this.files[0])">
                        </div>
                
                        {{-- <div class="form-group">
                            <button type="submit" class="btn btn-success me-2">Update</button>
                        </div> --}}
                
                    {{-- </form> --}}
                </div>
                <div class="col-lg-6">

                    {{-- <form class="form-load pr-4 input-group-sm" type="create" action="{{ route('my-profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="address">
                        <h3 class="text-center">Address</h3>
                        <div class="form-group">
                            <label for="">Phone </label>
                            <input type="text" class="form-control input-group-sm" name="phone" placeholder="Phone" value="{{@$user_details->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="address" name="address" class="form-control input-group-sm" value="{{@$user_details->street_address}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Apt,Suite</label>
                            <input type="text" class="form-control input-group-sm" name="apt" placeholder="Apt,Suite" value="{{@$user_details->apt_suite}}">
                        </div>
                        <div class="form-group">
                            <label for="">City </label>
                            <input type="text" class="form-control input-group-sm" name="city" placeholder="City" value="{{@$user_details->city}}">
                        </div>
                        <div class="form-group">
                            <label for="">Postcode/Zip </label>
                            <input type="text" class="form-control input-group-sm" name="postcode" placeholder="Postcode/Zip" value="{{@$user_details->post_code}}">
                        </div>
                        
                
                        <div class="form-group">
                            <button type="submit" class="btn btn-success me-2">Update</button>
                        </div>
                
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control {
    height: calc(1em + 1.34rem + 2px) !important;
}
</style>
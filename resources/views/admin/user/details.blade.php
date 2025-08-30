<div class="row">
    @if($user->avatar)
    <div class="col-12">
        <div class="d-flex justify-content-center mb-2">
            <img src="@if($user->avatar){{asset('frontend/images/profile/'.$user->avatar)}}@endif" alt="" style="height: 150px;border-radius:50%;">
        </div>
    </div>
    @endif
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill bg-white">
            <div class="card-body">
                <h4>Information</h4>
                <p class="card-text">
                    Name     : {{$user->name}}<br>
                    Email    : {{$user->email}}<br>
                    Role    : {{@$user->roles->role_name}}<br>
                    User Points : {{@$user->points->sum('point')}}<br>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex">
        <div class="card flex-fill bg-white">
            <div class="card-body">
                <h4>Details</h4>
                <p class="card-text">
                    Address  : {{@$user->details->address}}<br>
                    Apt Suite: {{@$user->details->apt_suite}}<br>
                    City     : {{@$user->details->city}}<br>
                    Postcode : {{@$user->details->postcode}}<br>
                    Phone    : {{@$user->details->phone}}<br>
                    
                </p>
            </div>
        </div>
    </div>
</div>

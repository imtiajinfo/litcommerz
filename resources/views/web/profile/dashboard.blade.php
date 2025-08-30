<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h3 class="font-size-18 mb-3 text-center">Basic Information</h3>
            <ul class="list-group list-group-borderless">
                <img id="profileImage" style="height: 100px;width:100px" src="@if($profile->avatar){{asset('frontend/images/profile/'.$profile->avatar)}}@endif"><br>
                <li class="list-group-item px-0"><i class="fas fa-check mr-2 text-green font-size-16 d-none"></i> Name : {{$profile->name}}</li>
                <li class="list-group-item px-0"><i class="fas fa-check mr-2 text-green font-size-16 d-none"></i> Email : {{$profile->email}}</li>
                <li class="list-group-item px-0 d-none"><i class="fas fa-check mr-2 text-green font-size-16 d-none"></i> Verified : Verified</li>
            </ul>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h3 class="font-size-18 mb-3 text-center">My Points</h3>
            <ul class="list-group list-group-borderless">
                <h4 class="text-center">{{$points}}</h4>
            </ul>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action p-3 pl-4 @if($type=='dashboard') active @endif" href="{{url('my-profile')}}?type=dashboard"><b> Dashboard</b></a>
        <a class="list-group-item list-group-item-action p-3 pl-4 @if($type=='profile') active @endif" href="{{url('my-profile')}}?type=profile"><b> My Profile</b></a>
        <a class="list-group-item list-group-item-action p-3 pl-4 @if($type=='password') active @endif" href="{{url('my-profile')}}?type=password"><b> Password</b></a>
        <a class="list-group-item list-group-item-action p-3 pl-4 @if($type=='order') active @endif" href="{{url('orders')}}"><b> Orders</b></a>
        <a class="list-group-item list-group-item-action p-3 pl-4 @if($type=='points') active @endif" href="{{url('my-profile')}}?type=points"><b> Points History</b></a>
        <a class="list-group-item list-group-item-action p-3 pl-4" href="{{url('logout')}}"><b> Logout</b></a>

    </div>
</div>

<style>
.p-3 {
    padding: .75rem !important;
}
.pl-4 {
    padding-left: 1.75rem !important;
}
</style>

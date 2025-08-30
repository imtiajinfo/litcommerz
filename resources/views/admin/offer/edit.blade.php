<form class="form-load" type="update" action="{{ route('admin.offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Offer Title<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$offer->name}}" name="offer_name" placeholder="Offer Title" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" src="{{asset('frontend/images/offer/'.$offer->banner)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Home Show</label>
                <select class="form-control" name="home_show" id="">
                    <option value="">Select</option>
                    <option @if($offer->home_show == 1){{"selected"}}@endif value="1">Yes</option>
                    <option @if($offer->home_show == 0){{"selected"}}@endif value="0">No</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Start Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" value="{{$offer->start_date}}" name="start_date" placeholder="Start Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">End Date<span class="text-danger">*</span></label>
                <input type="date" value="{{$offer->end_date}}" class="form-control" name="end_date" placeholder="End Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($offer->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($offer->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
        
    </div>

    <x-admin.modal.update-btn />
    
</form>
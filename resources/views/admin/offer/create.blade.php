<form class="form-load" type="create" action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Offer Title<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="offer_name" placeholder="Offer Title" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Home Show</label>
                <select class="form-control" name="home_show" id="">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Start Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="start_date" value="{{date('Y-m-d')}}" placeholder="Start Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">End Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="end_date" value="{{date('Y-m-d')}}" placeholder="End Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12" style="display: none">
            <div class="form-group">
                <label class="required">Amount</label>
                <input type="number" class="form-control" name="amount" value="1" placeholder="Amount" required>
            </div>
        </div>
        
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />
    
</form>



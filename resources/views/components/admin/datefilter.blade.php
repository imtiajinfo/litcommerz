<div class="search-set">
  <form class="search-input" id="date-filter">
    <div class="row">
        <div class="col-5">
          <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" placeholder="From Date">
        </div>
        <div class="col-5">
              <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" placeholder="To Date">
        </div>
        <div class="col-2"><button class="btn btn-primary" type="submit"><img src="{{ asset('admin/assets/img/icons/search-white.svg') }}" alt="img"></button></div>
    </div>
  </form>
</div>
<div class="page-header">
    <div class="page-title">
        <h4>Product Offer Sorting</h4>
        <h6>View/Search product Offer Sorting</h6>
    </div>
    <div class="page-btn d-flex d-inline">
        <a href="offers" class="btn btn-added anchor">
            List Offer
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <ul class="list-group" id="basic-list-group">
            @foreach ($offers as $key => $item)

                <li class="list-group-item draggable draggable-sl" sl={{$item->id}}>
                    <div class="media">
                        <div class="media-body">
                            <h6 class="mt-0"><img style="height:30px" src="{{ asset('frontend/images/offer/'.$item->banner) }}" alt="product"> {{ $item->name }}</h6>
                        </div>
                    </div>
                </li>
                
            @endforeach
            
        </ul>

        <button class="btn btn-primary mt-3" id="offer-sorting">Update</button>

    </div>
</div>
<script src="{{ asset('admin/assets/plugins/dragula/js/drag-drop.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/dragula/js/dragula.min.js') }}"></script>
<style>
    .list-group-item{
        cursor: pointer;
    }
</style>

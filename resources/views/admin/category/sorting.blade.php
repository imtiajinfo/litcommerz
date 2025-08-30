<div class="page-header">
    <div class="page-title">
        <h4>Product Category Sorting</h4>
        <h6>View/Search product Category Sorting</h6>
    </div>
    <div class="page-btn d-flex d-inline">
        <a href="category" class="btn btn-added anchor">
            List Category
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <ul class="list-group" id="basic-list-group">
            @foreach ($categories as $key => $item)

                <li class="list-group-item draggable draggable-sl" sl={{$item->id}}>
                    <div class="media">
                        <div class="media-body">
                            <h6 class="mt-0"><img style="height:30px" src="{{ asset('frontend/images/category/'.$item->image) }}" alt="product"> {{ $item->category_name }}</h6>
                        </div>
                    </div>
                </li>
                
            @endforeach
            
        </ul>

        <button class="btn btn-primary mt-3" id="category-sorting">Update</button>

    </div>
</div>
<script src="{{ asset('admin/assets/plugins/dragula/js/drag-drop.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/dragula/js/dragula.min.js') }}"></script>
<style>
    .list-group-item{
        cursor: pointer;
    }
</style>

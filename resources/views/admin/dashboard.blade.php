<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash2">
            <div class="dash-widgetimg">
                <span><img src="{{ asset('admin/assets/img/icons/dash3.svg')}}" alt="img"></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>¥<span class="counters" data-count="{{$total_stock}}">{{number_format($total_stock,0)}}</span></h5>
                <h6>Total Stock</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget">
            <div class="dash-widgetimg">
                <span><img src="{{ asset('admin/assets/img/icons/dash1.svg')}}" alt="img"></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>¥<span class="counters" data-count="{{$total_sale}}">{{number_format($total_sale, 0)}}</span></h5>
                <h6>Total Sale</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash1">
            <div class="dash-widgetimg">
                <span><img src="{{ asset('admin/assets/img/icons/dash2.svg')}}" alt="img"></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>¥<span class="counters" data-count="{{$total_pending}}">{{number_format($total_pending, 0)}}</span></h5>
                <h6>Total Pending</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash3">
            <div class="dash-widgetimg">
                <span><img src="{{ asset('admin/assets/img/icons/dash4.svg')}}" alt="img"></span>
            </div>
            <div class="dash-widgetcontent">
                <h5><span class="counters" data-count="{{$total_product}}">{{$total_product}}</span></h5>
                <h6>Total Product</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count">
            <a href="user-list" class="anchor text-white">
                <div class="dash-counts">
                    <h4>{{$customers}}</h4>
                    <h5>Customers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das1">
            <a href="orders?status=all" class="anchor text-white">
                <div class="dash-counts">
                    <h4>{{$orders}}</h4>
                    <h5>Total Order</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das2">
            <a href="orders?status=pending" class="anchor text-white">
                <div class="dash-counts">
                    <h4>{{$pending_orders}}</h4>
                    <h5>Pending Order</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file-text"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das3">
            <a href="orders?status=complete" class="anchor text-white">
                <div class="dash-counts">
                    <h4>{{$completed_orders}}</h4>
                    <h5>Completed Order</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white d-flex align-items-center" style="background: #28c76f; border-radius: 0.25rem 0.25rem 0 0;">
            <i class="fas fa-chart-bar me-2"></i>
            <h5 class="mb-0">Sales Overview (Last 6 Months)</h5>
        </div>
        <div class="card-body" style="background: #f8f9fa; border-radius: 0 0 0.25rem 0.25rem;">
            <div id="dashboard_chart" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(@json($chart_data));

        var options = {
            chart: { title: '' },
            bars: 'vertical',
            height: 500,
            colors: ['#ff9f43'],
            legend: { position: 'none' },
            backgroundColor: '#f8f9fa',
            chartArea: { width: '80%', height: '70%' },
            vAxis: { gridlines: { color: '#e0e0e0' } },
            hAxis: { textStyle: { fontSize: 12 } }
        };

        var chart = new google.charts.Bar(document.getElementById('dashboard_chart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    window.addEventListener('resize', drawChart);
</script>

{{-- <div class="row">
    <div class="col-lg-7 col-sm-12 col-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Purchase & Sales</h5>
                <div class="graph-sets">
                    <ul>
                        <li>
                            <span>Sales</span>
                        </li>
                        <li>
                            <span>Purchase</span>
                        </li>
                    </ul>
                    <div class="dropdown">
                        <button class="btn btn-white btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            2022 <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">2022</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">2021</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item">2020</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="sales_charts"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-sm-12 col-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Recently Added Products</h4>
                <div class="dropdown">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropset">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a href="productlist.html" class="dropdown-item">Product List</a>
                        </li>
                        <li>
                            <a href="addproduct.html" class="dropdown-item">Product Add</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dataview">
                    <table class="table datatable ">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Products</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product22.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">Apple Earpods</a>
                                </td>
                                <td>$891.2</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product23.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">iPhone 11</a>
                                </td>
                                <td>$668.51</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product24.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">samsung</a>
                                </td>
                                <td>$522.29</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product6.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">Macbook Pro</a>
                                </td>
                                <td>$291.01</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-0">
    <div class="card-body">
        <h4 class="card-title">Expired Products</h4>
        <div class="table-responsive dataview">
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Brand Name</th>
                        <th>Category Name</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><a href="javascript:void(0);">IT0001</a></td>
                        <td class="productimgname">
                            <a class="product-img" href="productlist.html">
                                <img src="assets/img/product/product2.jpg" alt="product">
                            </a>
                            <a href="productlist.html">Orange</a>
                        </td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>12-12-2022</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="javascript:void(0);">IT0002</a></td>
                        <td class="productimgname">
                            <a class="product-img" href="productlist.html">
                                <img src="assets/img/product/product3.jpg" alt="product">
                            </a>
                            <a href="productlist.html">Pineapple</a>
                        </td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>25-11-2022</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><a href="javascript:void(0);">IT0003</a></td>
                        <td class="productimgname">
                            <a class="product-img" href="productlist.html">
                                <img src="assets/img/product/product4.jpg" alt="product">
                            </a>
                            <a href="productlist.html">Stawberry</a>
                        </td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>19-11-2022</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><a href="javascript:void(0);">IT0004</a></td>
                        <td class="productimgname">
                            <a class="product-img" href="productlist.html">
                                <img src="assets/img/product/product5.jpg" alt="product">
                            </a>
                            <a href="productlist.html">Avocat</a>
                        </td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>20-11-2022</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}
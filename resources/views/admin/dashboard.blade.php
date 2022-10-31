@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ __('admin/nav.dashboard') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $ordersCount }}</h3>
                    <p>{{ __('admin/home.new_orders') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                {{-- <a href="{{ route('admin.order.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productsCount }}</h3>
                    <p>{{ __('admin/home.products_count') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                {{-- <a href="{{ route('admin.branch.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $customersCount }}</h3>
                    <p>{{ __('admin/home.user_reg') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add fas fa-users"></i>
                </div>
                {{-- <a href="{{ route('admin.customer.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $categoriesCount }}</h3>
                    <p>{{ __('admin/home.category_count') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph fas fa-pie-chart"></i>
                </div>
                {{-- <a href="{{ route('admin.category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            email
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>
                                {{ $customer->name }}
                            </td>
                            <td>
                                {{ $customer->email }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

@stop

@section('js')
<script src="{{asset('/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    {{-- <script> console.log('Hi!'); </script> --}}

    <script>
        $(document).ready(function() {
           
            $('#myTable').DataTable();
        });
    </script>
@stop

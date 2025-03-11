@extends('admin.layouts.app')
@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white">
                        <h3 class="mt-2">Dashboard</h3>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">



                            {{-- todays orders --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-dark">
                                                today's orders
                                            </strong>
                                            <span class="badge bg-dark">
                                                {{ $todayOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center bg-white">
                                        <strong class="badge bg-dark">{{ $todayOrders->sum('total') }}</strong>
                                    </div>

                                </div>
                            </div>

                            {{-- yesterday orders --}}


                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-primary">
                                                yesterday's orders
                                            </strong>
                                            <span class="badge bg-primary">
                                                {{ $yesterdayOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center bg-white">
                                        <strong class="badge bg-primary">{{ $yesterdayOrders->sum('total') }}</strong>
                                    </div>

                                </div>
                            </div>

                            {{-- month orders --}}

                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-danger">
                                                Month's orders
                                            </strong>
                                            <span class="badge bg-danger">
                                                {{ $monthOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center bg-white">
                                        <strong class="badge bg-danger">{{ $monthOrders->sum('total') }}</strong>
                                    </div>

                                </div>
                            </div>


                            {{-- years order --}}
                            <div class="col-md-6 mb-2">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <div class="d-flex justify-content-between">
                                            <strong class="badge bg-success">
                                                year's orders
                                            </strong>
                                            <span class="badge bg-success">
                                                {{ $yearOrders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center bg-white">
                                        <strong class="badge bg-success">{{ $yearOrders->sum('total') }}</strong>
                                    </div>

                                </div>
                            </div>


                        </div>




                    </div>



                </div>
            </div>
        </div>

    </div>
@endsection

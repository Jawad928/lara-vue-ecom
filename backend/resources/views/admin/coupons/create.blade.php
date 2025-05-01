@extends('admin.layouts.app')
@section('title')
    Add New Coupon
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white ">
                        <h3 class="mt-2">
                            Add New Coupon
                        </h3>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name*</label>
                                            <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                                name="name" id="name" aria-describedby="helpId" placeholder="Name*"
                                                value="{{ old('name') }}" />
                                            @error('name')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                        <div class="mb-3">
                                            <label for="discount" class="form-label">Discount*</label>
                                            <input type="number"
                                                class="form-control  @error('discount') is-invalid @enderror"
                                                name="discount" id="discount" aria-describedby="helpId"
                                                placeholder="Discount*" value="{{ old('discount') }}" />
                                            @error('discount')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                        <div class="mb-3">
                                            <label for="valid_until" class="form-label">Validity*</label>
                                            <input type="datetime-local" min="{{ \Carbon\Carbon::now()->addDays(1) }}"
                                                value="{{ old('valid_until', \Carbon\Carbon::now()->format('Y-m-d\TH:i:s')) }}"
                                                class="form-control  @error('valid_until') is-invalid @enderror"
                                                name="valid_until" id="valid_until" aria-describedby="helpId"
                                                placeholder="Validity*" />
                                            @error('valid_until')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>




                                        <button type="submit" class="btn btn-sm btn-dark">
                                            Submit
                                        </button>


                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

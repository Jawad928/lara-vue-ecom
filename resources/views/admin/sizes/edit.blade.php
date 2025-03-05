@extends('admin.layouts.app')
@section('title')
    Edit Size
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white ">
                        <h3 class="mt-2">
                            Edit Size
                        </h3>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name*</label>
                                            <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                                name="name" id="name" aria-describedby="helpId" placeholder="Name*"
                                                value="{{ $size->name, old('name') }}" />
                                            @error('name')
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

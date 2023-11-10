@extends('admin_layout/master')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Modals</h4>
        </div>
    </div>
</div>
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Upload You Modals</h4>
        </div>
    </div>
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Modal Upload</h5>
            </div>
            <form action="{{ url('addModalProcc') ?? '' }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Modal Name</label>
                            @error('name')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="slug">Slug</label>
                            @error('slug')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="slug" name="slug">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="brand">Brand</label> <br>
                            @error('brand')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            @foreach ($brands as $brand )
                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="{{ $brand->id ?? '' }}" class="custom-control-input" id="brand{{ $brand->id ?? '' }}" name="brand[]">
                                    <label class="custom-control-label" for="brand{{ $brand->id ?? '' }}">{{ $brand->name ?? '' }}</label>
                                </div>
                               
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="available_graphics">Available Graphics</label> <br>
                            @error('available_graphics')
                            <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            @foreach ($graphics as $graphic)
                            
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="{{ $graphic->id ?? '' }}" class="custom-control-input" id="available_graphics{{ $graphic->id ?? '' }}" name="available_graphics[]">
                                <label class="custom-control-label" for="available_graphics{{ $graphic->id ?? '' }}">{{ $graphic->name ?? '' }}</label>
                            </div>
                            
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="description">Description</label>
                            @error('description')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="front_image">Modal Image Front View</label>
                            @error('front_image')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="front_image" name="front_image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="side_image">Modal Image Side View</label>
                            @error('side_image')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="side_image" name="side_image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="top_image">Modal Image Top View</label>
                            @error('top_image')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="top_image" name="top_image">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Next <span style="margin-left: 1rem;" class="mr-3"><i class="fas fa-long-arrow-alt-right"></i></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#name').on('keyup', function() {
        let name = $(this).val().toLowerCase();
        let slug = name.replace(/\s+/g, "-"); // Replace consecutive spaces with a single dash
        $('#slug').val(slug);
    });
});
</script>
@endsection
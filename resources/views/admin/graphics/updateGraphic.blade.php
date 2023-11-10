@extends('admin_layout/master')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Graphics</h4>
        </div>
    </div>
</div>
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Update You Graphic : {{ $graphic->name ?? '' }}</h4>
        </div>
    </div>
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Graphic Update</h5>
            </div>
            <form action="{{ url('updateGraphicProcc') ?? '' }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id"  value="{{ $graphic->id ?? '' }}">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            @error('name')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $graphic->name ?? '' }}">
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
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ $graphic->slug ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="image">Material</label>
                            @error('material')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="material" name="material" value="{{ $graphic->material ?? ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="image">Brand Image</label>
                            @error('image')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="image-group">
                                <img src="{{ asset('graphics_images/'.$graphic->image) ?? '' }}" alt="">
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Update Graphic</button>
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
        let slug = name.replace(/\s+/g, "-");
        $('#slug').val(slug);
    });
});
</script>
@endsection
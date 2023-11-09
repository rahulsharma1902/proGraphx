@extends('admin_layout/master')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Colors</h4>
        </div>
    </div>
</div>
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Update You Color : {{ $color->name ?? '' }}</h4>
        </div>
    </div>
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Color Update</h5>
            </div>
            <form action="{{ url('updateColorProcc') ?? '' }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id"  value="{{ $color->id ?? '' }}">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            @error('name')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $color->name ?? '' }}">
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
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ $color->slug ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label" for="image">Color Code</label>
                            @error('color_code')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="form-control-wrap">
                                <input type="color" class="form-control" id="color_code" name="color_code" value="{{ $color->color_code ?? '' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Update Color</button>
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
@extends('admin_layout/master')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Modals : Body Parts</h4>
        </div>
    </div>
</div>
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Upload You Modals : Body Parts</h4>
        </div>
    </div>
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Modal Upload</h5>
            </div>
            <form action="{{ url('addModalBodyPartProcc') ?? '' }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            @error('name')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="">
                                <object id="svgObject" style="width:100%;" data="{{ asset('modals_images/'.$modal->side_image) ?? '' }}" type=""></object>
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
        $('#svgObject').on('load', function() {
            var svgDoc = $('#svgObject')[0].contentDocument;
            
            $(svgDoc).find('path').on('click', function() {
                $(this).attr('fill', 'red').addClass('body_parts1');
            });
        });
    });
</script>

@endsection
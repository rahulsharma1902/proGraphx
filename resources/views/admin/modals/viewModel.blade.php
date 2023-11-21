@extends('admin_layout/master')
@section('content')
<style>
/* Add any additional styling here */
.slick-carousel {
    width: 60%;
    margin: 0 auto;
}

.slick-slide {
    text-align: center;
}

.slide-content {
    padding: 20px;
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.slick-next,
.slick-prev {
    font-size: 10px !important;
}
</style>
<div class="nk-block nk-block-lg" id="maindiv">
    <div class="nk-block-head d-flex justify-content-between">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Model : {{ $model->name ?? '' }}</h4>
            <div class="nk-block-des">
                <p><code class="code-class"></code> </p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="slick-carousel">
        <div>
            <div class="slide-content">
                <div class="">
                    <object class="svgObject" id="" style="width:100%;"
                        data="{{ asset('modals_images/'.$model->side_image) ?? '' }}" type=""></object>
                </div>
                <h3>Side Image</h3>
            </div>
        </div>
        <div>
            <div class="slide-content">
                <div class="">
                    <object class="svgObject" id="" style="width:100%;"
                        data="{{ asset('modals_images/'.$model->front_image) ?? '' }}" type=""></object>
                </div>
                <h3>Front Image</h3>
            </div>
        </div>
        <div>
            <div class="slide-content">
                <div class="">
                    <object class="svgObject" id="" style="width:100%;"
                        data="{{ asset('modals_images/'.$model->side_image) ?? '' }}" type=""></object>
                </div>
                <h3>Top Image</h3>
            </div>
        </div>

    </div>
</div>
<hr>
<div class="row g-gs">
    @foreach ($model->bodyParts as $bodyPart)
        
    <div class="col-md-6">
        <div class="card card-bordered">
            <div class="card-inner">
                <h4 class="card-title mb-1 text-center">{{ $bodyPart->name ?? '' }}</h4>
               
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('modals_images/'.$bodyPart->partImage) ?? '' }}" alt="">
                    <!-- <object class="svgObject" id="" style="width:100%;" data="{{ asset('modals_images/'.$model->side_image) ?? '' }}" type=""></object> -->
                </div>
                <div class="collapse" id="collapseDes{{$bodyPart->id ?? '' }}" style="">
                    <div class="divider"></div>
                    <div class="rating-card-description">
                        <div class="row">
                            @foreach($bodyPart->accents as $accent)
                            <div class="col-lg-12">
                                <h5 class="">{{ $accent->name ?? '' }}</h5>
                                <div class="colorSection">
                                    <span>Avlaible Colors :</span>
                                    <input type="color" disabled/>
                                    <input type="color" disabled/>
                                    <input type="color" disabled/>
                                </div>
                                <div class="accentImage">

                                    <object class="svgObject" id="" style="width:100%;" data="{{ asset('modals_images/'.$model->updatedImage) ?? '' }}" type=""></object>

                                </div>
                                <hr>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer rating-card-footer bg-light border-top d-flex align-center justify-content-between">
                <a class="switch-text collapsed" data-bs-toggle="collapse" href="#collapseDes{{$bodyPart->id ?? '' }}" aria-expanded="false">
                    <div class="link link-gray switch-text-normal">
                        <span>Less Info</span><em class="icon ni ni-upword-ios"></em>
                    </div>
                    <div class="link link-gray switch-text-collapsed">
                        <span>View Accents</span><em class="icon ni ni-downward-ios"></em>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @endforeach
</div>
<!-- <div class="card card-bordered product-card">
    <div class="product-thumb">
        <object class="svgObject" id="" style="width:100%;" data="{{ asset('modals_images/'.$model->top_image) ?? '' }}"
            type=""></object>
    </div>
    <div class="card-inner text-center">
        <h5 class="product-title">{{ $model->name ?? '' }}</h5>
    </div>
</div> -->

<script type="text/javascript">
$().ready(function() {
    $('.slick-carousel').slick({
        arrows: true,
        centerPadding: "0px",
        dots: true,
        slidesToShow: 1,
        infinite: true
    });
});
</script>

@endsection
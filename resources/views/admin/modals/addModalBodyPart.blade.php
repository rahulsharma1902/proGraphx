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
                    <div class="col-lg-6 nk-block">
                        <!-- <div class="col-lg-5  my-4"> -->
                            <div class="row my-4 bodypartRow">
                                <div class="maindata bodyPart">
                                    <div class="col-lg-12 my-4">
                                        <div class="form-group">
                                            <label class="form-label" for="title">Body Part Title</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="image">Body Part Image</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" id="image" placeholder="Body Part Image">
                                            </div>
                                        </div>
                                        <div class="accentArea"></div>
                                        <button type="button" class="btn btn-outline-dark addAccent" id="addAccent">Add Accent</button>
                                        <button type="button" class="btn btn-outline-danger removeBodyPart">Remove Body Part</button> 
                                    </div>
                                </div>
                            </div>
                       
<!--                                     
                                    <button type="button" class="btn btn-outline-dark addAccent" id="addAccent">Add Accent</button>
                                    <button type="button" class="btn btn-outline-danger removeBodyPart">Remove Body Part</button> -->
                                <!-- </div> -->
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="form-group my-4">
                            <button type="button" class="btn btn-outline-info" id="addNewBodyPart">Add New Body Part</button>
                        </div>
                    <!-- </div> -->
                    
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

<div class="modal fade" tabindex="-1" id="modalDefault">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
            </div>
            <div class="modal-body">
                <img class="svgObject" id="svgObject" style="width:100%;" src="{{ asset('modals_images/'.$modal->side_image) ?? '' }}" alt="SVG Image">
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Modal Footer Text</span>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('#svgObject').on('load', function() {
    //         var svgDoc = $('#svgObject')[0].contentDocument;

    //         $(svgDoc).find('path').on('click', function() {
    //             $(this).attr('fill', 'red').addClass('body_parts1');
    //         });
    //     });
    // });
    $(document).ready(function () {
    var fillColor = '';

    $('#svgObject').on('load', function () {
        var svgDoc = $('#svgObject')[0].contentDocument;

        // Log the 'd' attribute of each path with the class 'body_parts1'
        $(svgDoc).find('path.body_parts1').each(function () {
            console.log($(this).attr('d'));
        });

        // Attach click event to all paths
        $(svgDoc).find('path').on('click', function () {
            // Store the color of the clicked path
            fillColor = $(this).attr('fill');

            // Remove class and color from all paths
            $('path').removeClass('body_parts1').attr('fill', fillColor);

            // Add class and color to the clicked path
            $(this).attr('fill', 'red').addClass('body_parts1');

            console.log(fillColor);
        });
    });
});


    // $(document).ready(function() {
    //     $("body").on("click", ".svgObject", function () {
    //         console.log('click..');
    //         var svgDoc = $('.svgObject')[0].contentDocument;
            
    //         $(svgDoc).find('path').on('click', function() {
    //             $(this).attr('fill', 'red').addClass('body_parts1');
    //         });
    //     });
    // });
</script>

<script>
    $(document).ready(function () {
    var bodyPartCount = 1;
    var accentCount = 1;
    $("#addNewBodyPart").on("click", function () {
        var newBodyPart = $(".bodyPart:first").clone();
        newBodyPart.find("input").val('').attr('disabled', false);
        newBodyPart.find(".accentArea").html('');
        $(".bodypartRow").append(newBodyPart);
    });

    $("body").on("click", ".removeBodyPart", function () {
        var bodyPart = $(this).closest('.bodyPart');
        bodyPart.remove();
    });

    $("body").on("click", ".addAccent", function () {
        var bodyPart = $(this).closest('.bodyPart');
        var accentArea = bodyPart.find('.accentArea');
        var inputElement = bodyPart.find('input[type="text"]');
        var title = inputElement.val();
     
        if (title == '') {
            alert('Please add your title first.');
            return false;
        }
        if (title) {
    var countVal = 0;

    $(".bodyPart input[type='text']").each(function () {
        if ($(this).val().trim() === title.trim()) {
            countVal++;
        }
    });

    if (countVal > 1) {
        alert('Please try a unique title.');
        return false;
    }
}

        var accentHTML = `
           
            <div id="accordion${accentCount}" class="accordion my-3">
                <div class="accordion-item">
                    <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#accordion-item-${accentCount}">
                        <h6 class="title">Accent Details</h6>
                        <span class="accordion-icon"></span>
                    </a>
                    <div class="accordion-body collapse show" id="accordion-item-${accentCount}" data-bs-parent="#accordion${accentCount}">
                        <div class="accordion-inner">
                            <div class="form-group">
                                <div class="accentCol">
                                    <div class="form-group">
                                        <label class="form-label" for="accentTitle${accentCount}">Accent Title</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="accentTitle${accentCount}" placeholder="Accent Title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="color">Colors</label> <br>
                                        @error('color')
                                            <span class="text-danger">*{{ $message }}</span>
                                        @enderror
                                        @foreach ($colors as $color)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{ $color->id ?? '' }}" class="custom-control-input" id="color{{ $color->id ?? '' }}${title}${accentCount}" name="brand[]">
                                                <label class="custom-control-label" for="color{{ $color->id ?? '' }}${title}${accentCount}">{{ $color->name ?? '' }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-success">Select Image Area</button>
                                        <button type="button" class="btn btn-outline-danger removeAccent">Remove Accent</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        `;

        accentArea.append(accentHTML);
        inputElement.prop('disabled', true);
        accentCount++;
    });

    $("body").on("click", ".removeAccent", function () {
        var accent = $(this).closest('.accordion');
        accent.remove();
    });

    function isTitleUnique(title) {
        var unique = true;
        $(".bodyPart input[type='text']").each(function () {
            if ($(this).val().trim() === title.trim()) {
                unique = false;
                return false; // exit the loop early
            }
        });
        return unique;
    }
});

</script>

@endsection
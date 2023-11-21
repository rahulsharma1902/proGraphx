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
            <form id="modelBodyForm" action="{{ url('addModalBodyPartProcc') ?? '' }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="model_id" value="{{ $modal->id ?? '' }}">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            @error('name')
                                <span class="text-danger">*{{ $message }}</span>
                            @enderror
                            <div class="">
                                <object class="svgObject" id="" style="width:100%;" data="{{ asset('modals_images/'.$modal->side_image) ?? '' }}" type=""></object>
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
                                                <input type="text" class="form-control bodyTitle" name="brandTitle[]" id="title" placeholder="Title" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control slug" name="slug[]" id="slug" placeholder="SLUG">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="image">Body Part Image</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control bodyImage" id="image" name="brandImage[]" placeholder="Body Part Image" required>
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
                            <button type="submit" class="btn btn-lg btn-primary">DONE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <div class="modal fade" tabindex="-1" id="modalDefault">
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
</div> -->
<script>
   $(document).ready(function () {
        // Attach keyup event to a parent element (document in this case)
        $(document).on('keyup', '.bodyTitle', function () {
            // Get the value of the current bodyTitle input
            var titleValue = $(this).val();

            // Remove white spaces and convert to lowercase
            var slugValue = titleValue.replace(/\s/g, '').toLowerCase();

            // Update the value of the corresponding slug input
            $(this).closest('.form-group').next().find('.slug').val(slugValue);
        });
    });
</script>
<script>

$(document).ready(function () {
    $('#modelBodyForm').submit(function (e) {
        e.preventDefault();  
        var hasError = false;

        $('input[type="text"]').each(function () {
            if ($(this).val().trim() === '') {
                hasError = true;
                $(this).addClass('required');

            } else {
                $(this).removeClass('required');
            }
        });
            if (hasError) {
                var firstEmptyField = $('input[type="text"].required:first');
                $('html, body').animate({
                    scrollTop: firstEmptyField.offset().top - 100 
                }, 500);

                NioApp.Toast('Please fill all required fields.', 'error', {position: 'top-right'});
                return false;
            }
        setTimeout(function () {
            var svgObjects = document.getElementsByClassName('svgObject');
            if (svgObjects.length > 0) {
                var svgObject = svgObjects[0]; 
                var svgDoc = svgObject.contentDocument;

                if (svgDoc) {
                    var xmlSerializer = new XMLSerializer();
                    var svgString = xmlSerializer.serializeToString(svgDoc);
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'updatedSVG',
                        value: svgString
                    }).appendTo('#modelBodyForm');
                    $('input:disabled').prop('disabled', false);
                    $('#modelBodyForm').unbind('submit').submit();
                }
            } else {
                // console.log('No elements with the class "svgObject" found.');
                NioApp.Toast('Failed to find you image', 'error', {position: 'top-right'});
            }
        }, 100);
    });
});


</script>
<script>
    $(document).ready(function () {
    var imageSelectionActive = false;

    $("body").on("click", ".selectImageArea", function () {
    var bodyPart = $(this).closest('.accentCol');
    var remove = bodyPart.find('.removeAccent');
    var inputElement = bodyPart.find('input[type="text"]');
    var inputColor = bodyPart.find('input[type="checkbox"]');
    // console.log(inputElement.val());
    var Pathclass = $(this).attr('data-class');
    var title = bodyPart.find('input[type="text"].' + Pathclass).val();
    // var title = inputElement.val();
        // console.log(Pathclass);
        // console.log(title);
    if (title == '') {
        // alert('Please add your title first.');
        NioApp.Toast('Please add your title first.', 'error', {position: 'top-right'});
        return false;
    }

    if (title) {
        var countVal = 0;

        $(".accentCol input[type='text']." + Pathclass + ":disabled").each(function () {
            // console.log($(this).val().trim());
            if ($(this).val().trim() === title.trim()) {
                countVal++;
                // console.warn(title.trim());
            }
        });

        if (countVal > 0) {
            // alert('Please try a unique title.');
            NioApp.Toast('Please try a unique title.', 'error', {position: 'top-right'});
            return false;
        }
    }
    var dinamicClass = title + $(this).attr('data-class');
    dinamicClass = dinamicClass.replace(/\s/g, '').toLowerCase();
    // console.warn(dinamicClass);

    
    // console.log($(this).attr('data-class'));
    // console.log(title);


    // console.warn(dinamicClass);

    inputElement.attr('disabled', true);
    $('.svgObject:first').attr('id', 'svgObject');
    // console.log($(this).html());
    $(this).html("Done").addClass('doneAreaSelection').removeClass('selectImageArea').attr('dinamicClass',dinamicClass);
    remove.attr('dinamicClass',dinamicClass);
    imageSelectionActive = true;
    $('button').each(function () {
        if (!$(this).hasClass('doneAreaSelection')) {
            $(this).prop('disabled', true);
        }
    });

    setTimeout(function () {
        var svgObject = document.getElementById('svgObject');
        var svgDoc = svgObject.contentDocument;

        // Check if the SVG content is available
        if (svgDoc) {
            // Remove previous click event handlers
            $(svgDoc).find('path').off('click');

            $(svgDoc).find('path').on('click', function () {
                if (imageSelectionActive) {
                    console.warn(dinamicClass);
                    console.warn(dinamicClass.length);
                    var oldColor = $(this).attr('fill');
                    if($(this).attr('data-selected') == 'done'){
                        NioApp.Toast('This Image Area has been already selected.', 'error', { position: 'top-right' });
                    }else{
                        if (oldColor == 'red') {
                            $(this).attr('fill', 'red').addClass(dinamicClass).attr('data-selected', 'done');
                        } else {
                            $(this).attr('fill', 'red').addClass(dinamicClass).attr('old-color', oldColor).attr('data-selected', 'done');
                        }
                    }
                }
            });
        } else {
            NioApp.Toast('Your Image is not loaded yet.', 'error', { position: 'top-right' });
            // console.log('SVG content not yet loaded.');
        }
    }, 100);

    });

    $('body').on("click", ".doneAreaSelection", function () {
        $('button').each(function () {
           $(this).prop('disabled', false);
        });
        var Dclass = $(this).attr('dinamicClass');
        var pathsWithDclass = $('path.' + Dclass);

        // Now pathsWithDclass contains all path elements with the specified Dclass
        // console.log('Paths with class ' + Dclass + ':', pathsWithDclass);
        var svgObject = document.getElementById('svgObject');

        // Wait for a short delay to ensure the content is loaded
        setTimeout(function () {
        var svgObject = document.getElementById('svgObject');
        var svgDoc = svgObject.contentDocument;

        // Check if the SVG content is available
        if (svgDoc) {
            var allPaths = $(svgDoc).find('path');
            console.warn(allPaths);
            allPaths.each(function () {
                if ($(this).hasClass(Dclass)) {
                    var oldColor = $(this).attr('old-color');

                    $(this).attr('fill', oldColor);
                }
            });

            // console.log(allPaths);
        } else {
            console.log('SVG content not yet loaded.');
        }
    }, 100);


        imageSelectionActive = false;
        $(this).hide();

        console.log('Image selection deactivated.');
    });

    // $('body').on("click", ".doneAreaSelection", function () {
    //     imageSelectionActive = false;
    //     var Dclass = $(this).attr('dinamicClass');
    //     $(this).hide();

    //     console.log('Image selection deactivated.');
    // });
});

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
    var bodyParts = $('.bodyPart');
    var bodyPart = $(this).closest('.bodyPart');
    var buttonsRemove = bodyPart.find(".removeAccent");

    // Check if there's only one body part
    if (bodyParts.length === 1) {
        NioApp.Toast('Sorry, you cannot remove the last body part.', 'error', {position: 'top-right'});
        // alert('Sorry, you cannot remove the last body part.');
        return;
    }

    var dynamicClasses = buttonsRemove.map(function () {
        return $(this).attr('dinamicclass');
    }).get();

    if (dynamicClasses.length > 0) {
        setTimeout(function () {
            var svgObject = document.getElementById('svgObject');
            var svgDoc = svgObject.contentDocument;

            if (svgDoc) {
                var allPaths = $(svgDoc).find('path');
                allPaths.each(function () {
                    var element = $(this);
                    dynamicClasses.forEach(function (className) {
                        if (element.hasClass(className)) {
                            element.removeClass(className).attr('data-selected', '');
                        }
                    });
                });
            } else {
                console.log('SVG content not yet loaded.');
            }
        }, 100);
    }

    bodyPart.remove();
    // console.log(dynamicClasses);
});


    // $("body").on("click", ".removeBodyPart", function () {
    //     console.log('click');
    //     var bodyPart = $(this).closest('.bodyPart');
    //     var titleVal = bodyPart.find("input.bodyTitle").val();
    //     var buttonRemove = bodyPart.find(".removeAccent");
    //     console.log(bodyPart);
    //     console.log(titleVal);
    //     // bodyPart.remove();
    // });


    $("body").on("click", ".addAccent", function () {
        var bodyPart = $(this).closest('.bodyPart');
        var accentArea = bodyPart.find('.accentArea');
        var inputElement = bodyPart.find('.bodyTitle');
        var bodyImage = bodyPart.find('.bodyImage');
        var title = inputElement.val();

        if (title == '') {
            NioApp.Toast('Please add your title first.', 'error', {position: 'top-right'});
            // alert('Please add your title first.');
            return false;
        }
        if (title) {
            var countVal = 0;

            $(".bodyPart input[type='text'] .bodyTitle").each(function () {
                if ($(this).val().trim() === title.trim()) {
                    countVal++;
                }
            });

            if (countVal > 1) {
                NioApp.Toast('Please try a unique title.', 'error', {position: 'top-right'});
                // alert('Please try a unique title.');
                return false;
            }
            title = title.replace(/\s/g, '').toLowerCase();
        }
        if(bodyImage.val() == ''){
            NioApp.Toast('Please add your Body Image first.', 'error', {position: 'top-right'});
            return false;
        }
        // console.log(title);

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
                                            <input type="text" name="accentTitle[${title}][]" class="form-control ${title} accetntTitle" id="accentTitle${accentCount}" placeholder="Accent Title" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="color">Colors</label> <br>
                                        @error('color')
                                            <span class="text-danger">*{{ $message }}</span>
                                        @enderror
                                        @foreach ($colors as $color)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{ $color->id ?? '' }}" class="custom-control-input" id="color{{ $color->id ?? '' }}${title}${accentCount}" name="brand[${title}][]">
                                                <label class="custom-control-label" for="color{{ $color->id ?? '' }}${title}${accentCount}">{{ $color->name ?? '' }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-success selectImageArea" data-id="" data-class="${title}" data-title="accentTitle${accentCount}">Select Image Area</button>
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
        var Dclass = $(this).attr('dinamicclass');

        if (Dclass) {
        setTimeout(function () {
            var svgObject = document.getElementById('svgObject');
            var svgDoc = svgObject.contentDocument;

            if (svgDoc) {
                var allPaths = $(svgDoc).find('path');
                allPaths.each(function () {
                    if ($(this).hasClass(Dclass)) {
                        $(this).removeClass(Dclass).attr('data-selected', '');
                    }
                });
            } else {
                console.log('SVG content not yet loaded.');
            }
        }, 100);
        }

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
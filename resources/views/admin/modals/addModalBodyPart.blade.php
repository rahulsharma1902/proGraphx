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
                                                <input type="text" class="form-control bodyTitle" name="brandTitle[]" id="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="image">Body Part Image</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" id="image" name="brandImage[]" placeholder="Body Part Image">
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
    $('#modelBodyForm').submit(function (e) {
        e.preventDefault();
        $('input:disabled').prop('disabled', false);
        var formData = $('#modelBodyForm').serializeArray();

        // Print form data to the console :: => ::
        console.log(formData);
    
       

        // If you want to display the form data on the page, you can do something like this:
        // formData.forEach(function (field) {
        //     console.log(field.name + ': ' + field.value);
        // });
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
    console.log(inputElement.val());
    var Pathclass = $(this).attr('data-class');
    var title = bodyPart.find('input[type="text"].' + Pathclass).val();

    if (title == '') {
        alert('Please add your title first.');
        return false;
    }

    if (title) {
        var countVal = 0;

        $(".accentCol input[type='text']." + Pathclass + ":disabled").each(function () {
            if ($(this).val().trim() === title.trim()) {
                countVal++;
            }
        });

        if (countVal > 0) {
            alert('Please try a unique title.');
            return false;
        }
    }
    // var dinamicClass = title+$(this).attr('data-class');
    var dinamicClass = ((title || '').trim() + ($(this).attr('data-class') || '').trim()).toLowerCase();

    console.warn(dinamicClass);

    console.log($(this).attr('data-class'));
    console.log(title);

    console.warn(dinamicClass);

    inputElement.attr('disabled', true);
    $('.svgObject:first').attr('id', 'svgObject');
    console.log($(this).html());
    $(this).html("Done").addClass('doneAreaSelection').removeClass('selectImageArea').attr('dinamicClass',dinamicClass);
    remove.attr('dinamicClass',dinamicClass);
    imageSelectionActive = true;
    $('button').each(function () {
        if (!$(this).hasClass('doneAreaSelection')) {
            $(this).prop('disabled', true);
        }
    });

        // After setting the ID, wait for a short delay to ensure the content is loaded
        setTimeout(function () {
            var svgObject = document.getElementById('svgObject');
            var svgDoc = svgObject.contentDocument;
           
            // Check if the SVG content is available
            if (svgDoc) {
                $(svgDoc).find('path').on('click', function () {
                    if (imageSelectionActive) {
                        var oldColor = $(this).attr('fill');
                        // var selected = $(this).attr('data-selected');
                        // if(selected == "done"){
                        //     alert('This area Is already Selected.');
                        // }else{
                            if(oldColor == 'red'){
                                $(this).attr('fill', 'red').addClass(dinamicClass).attr('data-selected','done'); 
                            }else{
                                $(this).attr('fill', 'red').addClass(dinamicClass).attr('old-color',oldColor).attr('data-selected','done');
                            }
                        // }
                        
                    }
                });
            } else {
                console.log('SVG content not yet loaded.');
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
        console.log('Paths with class ' + Dclass + ':', pathsWithDclass);
        var svgObject = document.getElementById('svgObject');

        // Wait for a short delay to ensure the content is loaded
        setTimeout(function () {
        var svgObject = document.getElementById('svgObject');
        var svgDoc = svgObject.contentDocument;

        // Check if the SVG content is available
        if (svgDoc) {
            var allPaths = $(svgDoc).find('path');

            allPaths.each(function () {
                if ($(this).hasClass(Dclass)) {
                    var oldColor = $(this).attr('old-color');

                    $(this).attr('fill', oldColor);
                }
            });

            console.log(allPaths);
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

    // $(document).ready(function() {
    //     $('#svgObject').on('load', function() {
    //         var svgDoc = $('#svgObject')[0].contentDocument;

    //         $(svgDoc).find('path').on('click', function() {
    //             $(this).attr('fill', 'red').addClass('body_parts1');
    //         });
    //     });
    // });

    // $(document).ready(function () {
    // $("body").on("click", ".selectImageArea", function () {
    //     console.log("Clicked");

    //     $('.svgObject:first').attr('id', 'svgObject');
    //     console.log('click');

    //     // After setting the ID, wait for a short delay to ensure the content is loaded
    //     setTimeout(function () {
    //         var svgObject = document.getElementById('svgObject');
    //         var svgDoc = svgObject.contentDocument;

    //         // Check if the SVG content is available
    //         if (svgDoc) {
    //             $(svgDoc).find('path').on('click', function () {
    //                 $(this).attr('fill', 'red').addClass('body_parts1');
    //             });
    //         } else {
    //             console.log('SVG content not yet loaded.');
    //         }
    //     }, 100);
    // });

    // $("body").on("click", ".svgObject", function () {
    //     console.log('click..');
    //     // Handle click on the SVG object if needed
    // });
    // $('body').on("click", ".doneAreaSelection", function () {
    //     svgChangeEnabled = !svgChangeEnabled;

    //     // Optionally, you can remove the 'svgObject' ID when changes are disabled
    //     if (!svgChangeEnabled) {
    //         $('.svgObject:first').removeAttr('id');
    //     }

    //     console.log('Changes to image paths and class are ' + (svgChangeEnabled ? 'enabled' : 'disabled'));
    // });
// });


    // $(document).ready(function () {
    // var fillColor = '';

    // $('#svgObject').on('load', function () {
    //     var svgDoc = $('#svgObject')[0].contentDocument;

    //     // Log the 'd' attribute of each path with the class 'body_parts1'
    //     $(svgDoc).find('path.body_parts1').each(function () {
    //         console.log($(this).attr('d'));
    //     });

    //     // Attach click event to all paths
    //     $(svgDoc).find('path').on('click', function () {
    //         // Store the color of the clicked path
    //         fillColor = $(this).attr('fill');

    //         // Remove class and color from all paths
    //         $('path').removeClass('body_parts1').attr('fill', fillColor);

    //         // Add class and color to the clicked path
    //         $(this).attr('fill', 'red').addClass('body_parts1');

    //         console.log(fillColor);
    //     }); 
    // });
    // $("body").on("click", ".selectImageArea", function() {
    //     console.log("Clicked"); 

    //     $('.svgObject:first').attr('id', 'svgObject');
    // });
    // $("body").on("click", ".svgObject", function () {
    //         console.log('click..');
    //         var svgDoc = $('.svgObject')[0].contentDocument;
            
    //         $(svgDoc).find('path').on('click', function() {
    //             $(this).attr('fill', 'red').addClass('body_parts1');
    //         });
    //     });
// });


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
    var bodyParts = $('.bodyPart');
    var bodyPart = $(this).closest('.bodyPart');
    var buttonsRemove = bodyPart.find(".removeAccent");

    // Check if there's only one body part
    if (bodyParts.length === 1) {
        alert('Sorry, you cannot remove the last body part.');
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
                            element.removeClass(className);
                        }
                    });
                });
            } else {
                console.log('SVG content not yet loaded.');
            }
        }, 100);
    }

    bodyPart.remove();
    console.log(dynamicClasses);
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
        var title = inputElement.val();
     
        if (title == '') {
            alert('Please add your title first.');
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
                                            <input type="text" name="accentTitle[]" class="form-control ${title} accetntTitle" id="accentTitle${accentCount}" placeholder="Accent Title">
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
                        $(this).removeClass(Dclass);
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
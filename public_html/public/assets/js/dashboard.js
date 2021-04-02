function displayInfoModal(message)
    {
        $.getJSON('/dashboards/fetchInfoModal/?jsoncallback=?',
            {message:message},
            function (data)
            {
                console.log("displayInfoModal" + data);
                //$('#modal-park').html(data.modal['body']);
                
                if (data.r == 1)
                    {
                        $('#modalTitleId').html(data.title);
                        $('.modal-body').html('<h3 class="text-center">' + data.message + '</h3>').append(data['modal']['cogs']);
                        $('.modal-footer').html('<button type=\"button\" class=\"text-right btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>');
                        $('#modal-main').modal().trigger('show').modal('handleUpdate');
                        setTimeout(function ()
                        {
                            $('#modal-main').modal().trigger('hide');
                            addImagesToSection();
                        }, 2000);
                        
                        addImagesToSection();
                    }
                else
                    {
                        $('#modalTitleId').html(data.title);
                        $('.modal-body').html('<h3 class="text-center">' + data.message + '</h3>').append(data['modal']);
                        $('.modal-footer').html('<button type=\"button\" class=\"text-right btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>');
    
                        alert("here");
                    }
            });
    }


function deleteSelectedImage()
    {
        deletedImages = Array();
    
        $('#sectionSelect.selectpicker').change(function ()
        {
            section = $('#sectionSelect.selectpicker').val();
        });
    
        section = $('#sectionSelect.selectpicker').val();
    
        $('img.image-selected').each(function ()
        {
            var imageurl = $(this).attr('src');
            var index = imageurl.lastIndexOf("/") + 1;
            var imagename = imageurl.substr(index);
        
            if ($(this).hasClass('image-selected'))
                {
                    $(this).removeClass('image-selected');
                }
        
            deletedImages.push({
                path   : imageurl,
                name   : imagename,
                type   : $(this).attr('alt'),
                section: $('#sectionSelect.selectpicker').val() !== null ? $('#sectionSelect.selectpicker').val() : section
            });
        });
    
        $.getJSON("/dashboards/deleteImage/?jsoncallback=?",
            {deletedImages: deletedImages, section: section},
            function (data)
            {
                updateSection(section);
                
                if (data.r == 1)
                    {
                    
                    
                    }
            });
        
    }



/**
 * Remove the selected images from
 * @returns {undefined}
 */
function removeSelectedImages()
    {
        var removedImages = Array();
        var section = 'none';
        
        $('#sectionSelect.selectpicker').change(function ()
        {
            section = $('#sectionSelect.selectpicker').val();
        });
        
        section = $('#sectionSelect.selectpicker').val();
        
        $('img.image-selected').each(function ()
        {
            var imageurl = $(this).attr('src');
            var index = imageurl.lastIndexOf("/") + 1;
            var imagename = imageurl.substr(index);
            
            if ($(this).hasClass('image-selected'))
                {
                    $(this).removeClass('image-selected');
                }
            
            removedImages.push({
                path   : imageurl,
                name   : imagename,
                type   : $(this).attr('alt'),
                section: $('#sectionSelect.selectpicker').val() !== null ? $('#sectionSelect.selectpicker').val() : section
            });
        });
        
        $.getJSON("/dashboards/removeSelectedItems/?jsoncallback=?",
            {removedImages: removedImages, section: section},
            function (data)
            {
                updateSection(section);
                // $('#modal-park').html(data.modal);
                
                
                if (data.r == 1)
                    {
                        $('#displayPaneId').html(data.selectedImagesHtml);
                        $('#confirmButtonDisplayId').html(data.confirm_button);
                        $("#modalTitleId").html('Images removed successfully');
                        $(".modal-body").html("<p>" + data.message + "</p>");
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');//.modal('handleUpdate');
    
                        updateSection(section);
    
                    }
                else if (data.r == 0)
                    {
                        $(".modal-header").html("<h5 class=\"modal-title\">Error removing images from section</h5>");
                        $(".modal-body").html("<p>Error saving images, please try again " + data.rerr_message + "</p>");
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');
                    }
            });
    }


/**
 * Add the selected images to the current
 * section. upto the max number of images
 * @returns
 */
function addImagesToSection()
    {
        var selectedImages = Array();
        var selectedSection;
        var activeFlag = false;
        
        $('#sectionSelect.selectpicker').change(function ()
        {
            selectedSection = $('#sectionSelect.selectpicker').val();
        });
        
        selectedSection = $('#sectionSelect.selectpicker').val();
        
        $('img.image-selected').each(function ()
        {
            var imageurl = $(this).attr('src');
            var index = imageurl.lastIndexOf("/") + 1;
            var imagename = imageurl.substr(index);
            
            selectedImages.push({
                path           : imageurl,
                name           : imagename,
                type           : $(this).attr('alt'),
                selectedSection: $('#sectionSelect.selectpicker').val() !== null ? $('#sectionSelect.selectpicker').val() : selectedSection
            });
        });
        
        
        $.getJSON("/dashboards/addImagesToSection/?jsoncallback=?",
            {selectedImages: selectedImages, selectedSection: selectedSection},
            function (data)
            {
                console.log("addImagesToSection");
                // $('#modal-park').html(data.modal);
                
                if (data.r == 1)
                    {
                        updateSection(selectedSection);
                        
                        $('#displayPaneId').html(data.sectionImagesHtml);
                        
                       // $('#displayPaneId').append(data.selectedImagesHtml);
                        $(".modal-header").html("<h5 class=\"modal-title\">Images saved successfully</h5>");
                        $(".modal-body").html("<p>" + data.message + "</p>");
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        
                        $('#modal-main').modal().trigger('hide');
                        
                        resetImageSelections();
                        selectedImages.length = 0;
                        
                    }
                else if (data.r == 0)
                    {
                        $(".modal-header").html("<h5 class=\"modal-title\">Error relocating images</h5>");
                        $(".modal-body").html("<p>Error saving images, please try again " + data.err_message + "</p>");
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');
                        resetImageSelections();
                        selectedImages.length = 0;
                        
                    }
            });
    }


/**
 * Update UI based on select box choice.
 * Display the section images
 *
 * @param {type} optionId
 * @returns {undefined}
 */
function updateSection(optionId)
    {
        var sectionId = optionId;
        
        $.getJSON('/dashboards/selectSection/?jsoncallback=?',
            {sectionId: sectionId},
            function (data)
            {
                
                if (data.r == 1)
                    {
                        $('.modal-header').html('<h5 class=\"modal-title\">Images saved successfully</h5>');
                        $('.modal-body').html('<p>' + data.message + '</p>').append(data['modal']['cogs']);
                        $('.modal-footer').html('<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>');
                        //$('#modal-main').modal().trigger('focus');
                        
                        let imgDiff = 0;
                        imgDiff = data.maxImageCount - data.currentImageCount;
                        
                        $('#sectionTitleId').html('Current Section:  ' + data.sectionTitle + ' - Max image count: ' + data.maxImageCount + ' ' + ' Select ' + imgDiff + ' additional images');
                        
                        $('#flashMessage').removeClass('alert alert-danger').addClass('alert alert-success').html(data.alert_message);
                        
                        $('#displayPaneId').html(data.sectionImagesHtml);
                        
                        return false;
                        
                    }
                if (data.r == 0)
                    {
                        $(".modal-header").html("<h5 class=\"modal-title\">Error retrieving images</h5>"),
                            $(".modal-body").html("<p>Please select a different section " + data.err_message + "</p>").append(data['modal']['cogs']);
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');
                        
                        $("#sectionTitleId").append('<div class="alert alert-danger" role="alert">' + data.err_message + '</div>');
                        $('#flashMessage').removeClass('alert alert-success').addClass('alert alert-dangert').html(data.err_message);
                        $('#displayPaneId').html(data.sectionImagesHtml);
                    }
            });
    }


/**
 * Highlight selected images with a purple
 * border.
 */
function displayImageAsActive()
    {
        if ($('#' + event.srcElement.id).hasClass('image-selected'))
            {
                $('#' + event.srcElement.id).removeClass('image-selected');
            }
        else
            {
                $('#' + event.srcElement.id).addClass('image-selected');
            }
        
        var selectedImgArray = Array();
        
        $('img.image-selected').each(function ()
        {
            selectedImgArray.push($(this).attr('src'));
        });
    }


function resetImageSelections()
    {
        $('img.image-selected').each(function ()
        {
            
            if ($(this).hasClass('image-selected'))
                {
                    $(this).removeClass('image-selected');
                }
        });
    }


function submitForm()
    {
        $('#updateImageSection').submit();
    }


/**
 * User has confirmed the changes.
 * Arrange for values to be updated
 * in the database
 *
 */
function updateImageSelection()
    {
        var selectedOrigin;
        
        $('#origins.selectpicker').change(function ()
        {
            selectedOrigin = $('#origins.selectpicker').val();
        });
        
        selectedOrigin = $('#origins.selectpicker').val();
        
        $.getJSON("/dashboards/confirmUpdate/?jsoncallback=?",
            {selectedOrigin: selectedOrigin},
            function (data)
            {
                if (data.r == 1)
                    {
                        // $('#modal-park').html(data.modal['body']);
                        
                        $(".modal-header").html("<h5 class=\"modal-title\">Images added to gallery</h5>");
                        $(".modal-body").html("<p>" + data.message + "</p><br>").append(data['cogs']);
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');
                    }
                if (data.r == 0)
                    {
                        $(".modal-header").html("<h5 class=\"modal-title\">Error relocating images</h5>");
                        $(".modal-body").html("<p>Error saving images, please try again " + data.rerr_message + "</p>");
                        $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                        $('#modal-main').modal().trigger('focus');
                    }
            });
        
        return false;
    }


/**
 * Find images with the image-selected class.
 * Get the src and alt attr's and send them to
 * be processed.
 *
 * Called when the a form is submitted
 *
 */
function saveImageSelections()
    {
        var selectedImgArray = Array();
        var selectedItem = 'none';
        
        $('#imageLocationSel.selectpicker').change(function ()
        {
            selectedItem = $('#imageLocationSel.selectpicker').val();
        });
        
        selectedItem = $('#imageLocationSel.selectpicker').val();
        
        $('img.image-selected').each(function ()
        {
            var imageurl = $(this).attr('src');
            var index = imageurl.lastIndexOf("/");
            var imagename = imageurl.substr(index);
            
            selectedImgArray.push({
                path   : imageurl,
                name   : imagename,
                type   : $(this).attr('alt'),
                section: $('#imageLocationSel').val() !== null ? $('#imageLocationSel.selectpicker').val() : selectedItem
            });
        });
        
        let userImages = selectedImgArray.length > 0 ? 1 : 0;
        
        $.getJSON("/dashboards/updateUserSelection/?jsoncallback=?",
            {images: selectedImgArray, userImages: userImages, selectedItem: selectedItem},
            function (data)
            {
                // $('#modal-park').html(data.modal);
                
                switch (data.r)
                    {
                        case 0:
                            $(".modal-header").html("<h5 class=\"modal-title\">Error relocating images</h5>");
                            $(".modal-body").html("<p>Error saving images, please try again " + data.err_message + "</p>");
                            $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                            $('#modal-main').modal().trigger('focus');
                            break;
                        case 1:
                            $('#displayPaneId').html(data.selectedImagesHtml);
                            $('#displayPane2Id').html(data.sectionImagesHtml);
                            $('#confirmButtonDisplayId').html(data.confirm_button);
                            
                            $('#modal-park').html(data.modal);
                            
                            $(".modal-header").html("<h5 class=\"modal-title\">Images saved successfully</h5>");
                            $(".modal-body").html("<p>" + data.message + "</p>");
                            $(".modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" style=\"background-color:#4c007f; color:#eee;\" data-dismiss=\"modal\">Close</button>");
                            $('#modal-main').modal().trigger('focus');
                            break;
                        case 2:
                            
                            
                            break;
                    }
            });
        
        
        return false;
    }


function getAdminBookings()
    {
        $.getJSON("/bookings/fetch/?jsoncallback=?",
            function (data)
            {
                if (data.r == 1)
                    {
                        $("#modal-main-title").html("<h2>updating booking table</h2>");
                        $("#modal-main-content").html("<h4>Fetching updated booking information.<br>Will just be a sec...</h4>");
                        $("#modal-main-buttons").html('<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>');
                        $('#testSpinn').modal().trigger('focus');
                    }
                if (data.r == 2)
                    {
                        $("#modal-main-title").html("<h2>Error</h2>");
                        $("#modal-main-content").html("<h4>Woops Something has gone wrong. <br>Try again in a moment</h4>");
                        $("#modal-main-buttons").html('<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>');
                        $('#testSpinn').modal().trigger('focus');
                    }
            });
        return false;
    }


function refreshBookings()
    {
        $('#testSpinn').on('shown.bs.modal', function ()
        {
            $('#testSpinn').modal().trigger('focus');
            // $(".modal-dialog").css("max-width", "500px");
        });
        
        getAdminBookings();
    }


$(document).ready(function ()
{
    $("#modal-main").on("shown.bs.modal", function ()
    {
        $(".modal-dialog").css("max-width", "500px");
    });
    
});


function errorModal(title, message)
    {
    
    }


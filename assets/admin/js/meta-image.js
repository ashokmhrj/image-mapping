jQuery(document).ready(function($){
    var canvas = $('.canvas-area[data-image-url]');
    canvas.canvasAreaDraw();
    // mapper_initialize();

    //For image upload
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Runs when the image button is clicked.
    $('#mapper-meta-image-button').click(function(e){

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#mapper_meta-image').val(media_attachment.url);
            // <img src="'+media_attachment.url+'" width="821px" />
            $('#mapper_image_preview').html('<textarea style="display:none;"  class="canvas-area" data-image-url="' + media_attachment.url + '"></textarea>');
            // $('#mapper_image_preview').html('<img id="mapper_event"  src="'+media_attachment.url+'" />'); 
            // canvas.destroy();
            canvas = null;
            canvas.canvasAreaDraw();
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });
    
});

    

    function mapper_initialize(){
        // mapping

    }
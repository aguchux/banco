
(function ($) {

    "use strict"

    $("a[href='#']").click((e)=>{
        e.preventDefault();
    });

    $(document).ready(function() {
        $('#summernote').summernote({
            focus: true,
            height: 400,
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });
    });


})(jQuery);
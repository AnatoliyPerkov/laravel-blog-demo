// function readURL(input, imgControlName) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function(e) {
//             $(imgControlName).attr('src', e.target.result);
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }


$("#removeImage1").click(function(e) {
    e.preventDefault();
    $("#imag").val("");
    $("#ImgPreview").attr("src", "");
    $('.preview1').removeClass('it');
    $('.btn-rmv1').removeClass('rmv');
});


function readURL(input, imgControlName) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(imgControlName).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imag").change(function() {
    // add your logic to decide which image control you'll use
    var imgControlName = "#ImgPreview";
    readURL(this, imgControlName);
    $('.preview1').addClass('it');
    $('.btn-rmv1').addClass('rmv');
});


(function() {

    'use strict';

    $('.input-file').each(function() {
        var $input = $(this),
            $label = $input.next('.js-labelFile'),
            labelVal = $label.html();

        $input.on('change', function(element) {
            var fileName = '';
            if (element.target.value) fileName = element.target.value.split('\\').pop();
            fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);

        });
    });

})();

    //Function that is called when the user clicks on the image
    function hide_image(id,photo){
    document.getElementById(id).style.display = 'none';
        document.getElementById(photo).style.display = 'none';

    }

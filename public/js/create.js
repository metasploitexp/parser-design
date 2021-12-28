var names = new Array();
$('.delete').on('click', function (event) {
    var $imgContainer = $(this).parents('.img-container');
    $imgContainer.slideUp();

    names.push($imgContainer.attr('data-id'));
    console.log(names.join(','))
    $('[name="files_to_delete"]').val(names.join(','))
})


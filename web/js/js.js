$(document).ready(function () {
    $("#dblClick").dblclick(function () {
        console.log(data)
    })
})
// $(document).on('dblclick', '.folder', function (e) {
//     e.stopPropagation();
//     var id = $(this).data('id');
//     console.log(id);
//     var folderContents = $(this).find(`[data-id=${id}]`)
//     console.log(folderContents);
// });
//
// $(document).on('click', '.file', function () {
//     var id = $(this).data('id');
// });

$(document).on('click', '.toggle', function () {
    var folder = $(this).closest('.folder');
    console.log(folder);
    var contents = folder.find('.folder-contents');
    if (contents.is(':visible')) {
        contents.slideUp();
        $(this).html('&#9658;');
        folder.siblings().show();
    } else {
        contents.slideDown();
        $(this).html('&#9660;');
        folder.siblings().hide();
    }
});

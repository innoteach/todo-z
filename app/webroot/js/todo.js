/* *
 * Library of custom functions for the todo list
 */

/**
 * When making a table sortable, this variable helps us get the width of each TD element in a row
 * @param pointer e
 * @param pointer ui
 * @returns {fixHelper.ui}
 */
var fixHelper = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},

   updateSortIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            sort = i+1;
            id = $(this).parent().attr('id');
            $(this).html(sort);
            $.ajax({
                url: "/tasks/reorder/"+encodeURIComponent(id)+"/"+encodeURIComponent(sort)
            });         
        });
    };
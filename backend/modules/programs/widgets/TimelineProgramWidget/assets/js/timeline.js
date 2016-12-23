$(function(){

    $(document).on('click', '.many-operations-timeline .glyphicon-plus', function(e) {
        var cloneBlock = $(this).closest('.clear').clone();
        $(cloneBlock).find('select, input').each(function(){
            $(this).val('');
        });
        $(cloneBlock).insertAfter($(this).closest('td').find('.clear').last());
    });

    $(document).on('click', '.many-operations-timeline .glyphicon-minus', function(e) {
        if ($(this).closest('td').children('.clear').length > 1) {
            $(this).closest('.clear').remove();
        } else {
            $(this).closest('.clear').find('select, input').each(function() {
                $(this).val('');
            })
        }
    });

});
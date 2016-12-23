jQuery(document).ready(function ($) {

    $('#news-type').on('change', function(){
        var type = $('#news-type :selected').text();
        if(type == 'Текстовая новость'){
            $('.video').hide();
            $('.preview').css('display', 'block');
        }
        else{
            $('.video').css('display', 'block');
            $('.preview').hide();
        }
    })


   

    //добавление видео
    $('#video-youtube_link').on('change', function(){
        var input = $('.field-news-videofile');
        if(input.css('display') == 'none'){
            input.css('display', 'block');
        }
        else{
            input.hide();
        }
    });

    $('#news-videofile').on('change', function(){
       var input = $('.field-video-youtube_link');
        if(input.css('display') == 'none'){
            input.css('display', 'block');
        }
        else{
            input.hide();
        }
    })




    $('#gallery-photos').change(function() {
        $('#image-block-new').html('');
        var index = $('#count').val();
        var i=0;
        $($(this)[0].files).each(function() {
            var self = $(this);
            var newblock = $('#template-block-image').clone();
            $(newblock).removeClass('hide');
            $(newblock).attr('id', '');
            index++;
            $(newblock).find('input[type="text"]').each(function() {
                $(this).attr('name', 'GalleryPhotos[' + i + '][image_alt]');
                $(this).attr('id', 'GalleryPhotos-' + i + '-image_alt');
            });
            $(newblock).find('textarea').each(function() {
                $(this).attr('name', 'GalleryPhotos[' + i + '][image_desc]');
                $(this).attr('id', 'GalleryPhotos-' + i + '-image_desc');
            });

            // удалить кнопку
            $(newblock).find('input[type="button"]').each(function(){
                $(this).remove();
            });

            // поставить текст для спанов
            $(newblock).find('label span').each(function() {
                $(this).text($(self)[0].name);
            });

            $(newblock).find('img').each(function() {
                $(this).attr('src', window.URL.createObjectURL($(self)[0]));
            });

            $('#image-block-new').append($(newblock));
            i++;
        })
        $('#count').val(index);
    })

    $('.btn-danger').click(function() {
        $(this).parent().parent().remove()
    })

//программа телепередач
    $('#timelineprogram-type').on('change load', function(){
        var text = $("#timelineprogram-type option:selected").text();
        if(text ==='Произвольная дата'){
            $('.field-day-id').addClass('hidden');
        }
        else{
            $('.field-day-id').removeClass('hidden');
        }
    });

    var text = $("#timelineprogram-type option:selected").text();
    if(text ==='Произвольная дата'){
        $('.field-day-id').addClass('hidden');
    }
    else{
        $('.field-day-id').removeClass('hidden');
    }

   $('#timelineprogram-program_id').on('change load', function(){
       var text = $("#timelineprogram-program_id option:selected").text();
       if(text !='Выберите программу'){
           $('.field-timelineprogram-tv_show').addClass('hidden');
           $('.field-timelineprogram-tv_show_preview').addClass('hidden');
       }
       else{
           $('.field-timelineprogram-tv_show').removeClass('hidden');
           $('.field-timelineprogram-tv_show_preview').removeClass('hidden');
       }
   });

    $('#timelineprogram-tv_show').on('change', function(){
       var text =$('#timelineprogram-tv_show').val();
        if(text !=''){
            $('.field-timelineprogram-program_id').addClass('hidden');
        }
        else{
            $('.field-timelineprogram-program_id').removeClass('hidden');
        }
    });
    //при загрузке для обновления
    var program = $("#timelineprogram-program_id option:selected").text();
    var tv_show = $('#timelineprogram-tv_show').val();
    if(program == 'Выберите программу' && tv_show!=''){
        $('.field-timelineprogram-program_id').addClass('hidden');
    }else{
        if(program != 'Выберите программу' && tv_show ==''){
            $('.field-timelineprogram-tv_show').addClass('hidden');
            $('.field-timelineprogram-tv_show_preview').addClass('hidden');
        }
    }


});
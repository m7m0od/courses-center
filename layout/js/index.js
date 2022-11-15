$(function(){
    'use strict';

    $("select").selectBoxIt({
        autoWidth:false
    });


    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
        
    }).blur(function () {

        $(this).attr('placeholder',$(this).attr('data-text'));
    });


    $('.confirm').click(function(){
        return confirm("Do You Rellay Want To Delete This ?");
    });


    $('.req').blur(function(){
        if($(this).val().length < 2 )
        {
            $(this).css("border","1px solid #F00");
            $(this).parent().find('.custom-alert').fadeIn(1000);
        }else{
            $(this).css("border","1px solid #080");
            $(this).parent().find('.custom-alert').fadeOut(1000);
        }
    });

    $('.passs').blur(function(){
        if($(this).val().length < 8 )
        {
            $(this).css("border","1px solid #F00");
            $(this).parent().find('.custom-alert').fadeIn(1000);
        }else{
            $(this).css("border","1px solid #080");
            $(this).parent().find('.custom-alert').fadeOut(1000);
        }
    });

    $('.show').hover(function(){
        $(this).parent().find('.inputForShow').attr('type','text');
    },function(){
        $(this).parent().find('.inputForShow').attr('type','password');
    });

/*
    $("#first").change(function(){  this
        var first = $(this).val();
        //console.log(first);
        $.ajax({ 
            method:"POST",
            url:"members.php",
            data:{fir:first},
            dataType:"text",
            success:function(data)
            {
                $('#second').html(data);
            }
        });
    });

/*
    $('#first').on('change',function(){
        var first = $(this).val();
        if(first){
            $.post(
                "members.php",
                {fir:first},
                function(data){
                $('#second').html(data);
            });
        }else{
            $('#second').html('<option>Select Country First</option>');
        }
    });
*/
    

});


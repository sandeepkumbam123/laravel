$(function () {

    $(document).on('mouseover mouseout', ".box", function() {


            $(this).find('.box-hover').fadeIn(100);
            $(".box-tresc").show();

        },
        function () {
            $(this).find('.box-hover').fadeOut(100);
            $(".box-tresc").hide();

        });

    $(".box-tresc").click(function () {

        //old_image,is_new_image,current_image
        $(".box").remove();
        $("#is_new_image").val("yes");
        $("#new_image").show();

    });
});
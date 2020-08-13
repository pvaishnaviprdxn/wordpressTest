(function($) {
    $(document).ready(function() {
      $('#grades-category').on('change', function() {
        var value = $(this).val();
        $.ajax({
            url:wpAjax.ajaxUrl,
            data: { action: 'filter', category : value},
            type: 'post',
            success: function(result) {
              $('.posts-filter').html(result);
            },
            error: function(result) {
              console.warn(result);
            }
        });
      });

      $(".show").on("click",function() { 
        loadposts();
        
        $(this).insertAfter('.posts-filter'); 
      });
      var ppp = 6; // Post per page
      var pageNumber = 1;

      function loadposts() {
        pageNumber++;
        var str = '&pageNumber='+pageNumber+'&ppp='+ppp+'&action=more_post_ajax';
        $.ajax({
            type: "POST",
            //dataType: "html",
            url: wpAjax.ajaxUrl,
            data: str,
            success: function(data){
                var $data = $(data);
                if($data.length){
                    $(".posts-filter").append($data);
                    $(".load").attr("disabled",false);
                } else{
                    $(".load").attr("disabled",true);
                }
            },
            error : function(data) {
              console.warn(data);
            }
        });
        return false;
    }
  });
})(jQuery);
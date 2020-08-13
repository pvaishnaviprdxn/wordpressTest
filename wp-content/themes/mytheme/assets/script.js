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
    });

})(jQuery);
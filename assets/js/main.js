jQuery(document).ready(function($) {
   let ham = document.querySelector('.menu_icone');
   ham.addEventListener('click', function () {
      this.nextElementSibling.classList.toggle('active')
   })

   $('#load-more').click(function() {
      var category_id = $(this).data('category');
      var paged = $(this).data('page');

      $.ajax({
         type: 'POST',
         url: ajax_object.ajax_url,
         data: {
            'action': 'req_cat',
            'category_id': category_id,
            'paged': paged + 1,
            'nonce': ajax_object.nonce
         },
         success: function(response) {
            $('.post_cnt').append(response);
            $('#load-more').data('page', paged + 1);
         }
      });
   });

   $('.category-link').click(function(e) {
      e.preventDefault(); // Empêcher le comportement par défaut des liens
      var category_id = $(this).data('category');
      $('#load-more').data('category', category_id).data('page', 1);
      $.ajax({
         type: 'POST',
         url: ajax_object.ajax_url,
         data: {
            'action': 'req_cat',
            'category_id': category_id,
            'nonce': ajax_object.nonce
         },
         success: function(response) {
            $('.post_cnt').html(response);

         },
         error: function(error) {
            console.log(error);
         }
      });
   });
});

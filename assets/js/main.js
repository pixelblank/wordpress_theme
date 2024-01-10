jQuery(document).ready(function($) {
   let ham = document.querySelector('.menu_icone');
   ham.addEventListener('click', function () {
      this.nextElementSibling.classList.toggle('active')
   })

   $(document).on('click', '.category-link, .category_list', function(e) {
      e.preventDefault(); // Empêcher le comportement par défaut des liens
      e.stopPropagation();
      var category_id;
      if($(this).hasClass('category-link')) {
         // Traiter en tant que category-link
         category_id = $(this).data('category');
      } else if($(this).hasClass('category_list')) {
         // Traiter en tant que category_list
         category_id = $(this).data('category'); // Par exemple, si le category_id est dans l'attribut href
      }
      console.log(category_id);
      const categoryLinks = document.querySelectorAll('.category-link');
      const catLoader = document.querySelector('#catLoader');
      catLoader.classList.add('active');
      categoryLinks.forEach(function(link) {
         link.parentElement.classList.remove('active');
      });
      this.parentElement.classList.add('active');
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
            catLoader.classList.remove('active');
         },
         error: function(error) {
            console.log(error);
            catLoader.classList.remove('active');
         }
      });
   });
});

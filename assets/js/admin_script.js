jQuery(document).ready(function($){
    var frame;

    $('.select-icone-cat').on('click', function(e){
        e.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: 'Sélectionnez ou téléchargez une icône',
            button: {
                text: 'Utiliser cette icône'
            },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('.icone-cat-field').val(attachment.url);
        });

        frame.open();
    });
});
jQuery(document).ready(function($) {
    $('.select-icone-categorie').click(function() {
        console.log('sdfqsmdlfj');
        // Ouvrir le sélecteur d'icônes et gérer la sélection
        // Mettre à jour la valeur du champ 'icone_cat' avec l'icône sélectionnée
    });
});
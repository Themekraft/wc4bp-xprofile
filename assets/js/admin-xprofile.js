jQuery(document).ready(function ($) {

    $("#wc4bp-option-form").submit(function (event) {

        $('.wc4bp-conditional-visibility-container').each(function () {
            var $container = $(this);
           var products = $container.find('.field.cv-products');

           var productSelection = products.find('.select2-selection__rendered');
           var productSelectionChoice = productSelection.find('.select2-selection__choice');
           if(productSelectionChoice.length===0){
               var name= products.find('.wc-search').attr('name');

               products.append('<input type="hidden" name="'+name+'" value="deleteProduct" />');
           }

           var categories = $container.find('.field.cv-categories');
            var categorySelection = categories.find('.select2-selection__rendered');
            var categorySelectionChoice = categorySelection.find('.select2-selection__choice');
            if(categorySelectionChoice.length===0){
                var nameCat= categories.find('.wc-search').attr('name');

                categories.append('<input type="hidden" name="'+nameCat+'" value="deleteCategory" />');
            }



        });
        return true;

    });
    $('.wc4bp-conditional-visibility-container').each(function () {
        var $container = $(this);
        $container.find('.cv-enabled input').each(function () {
            var $checkbox = $(this);

            // Reset checked status
            $checkbox.prop('checked', $checkbox.data('checked'));
            // Enable or disable search fields in response to change in checked status
            $checkbox.change(function () {
                if ($(this).is(":checked")) {

                    $container.find('.field.cv-products, .field.cv-categories').removeClass('disabled');
                }
                else {
                    $container.find('.field.cv-products, .field.cv-categories').addClass('disabled');

                }
            });
        });

        $container.find('.wc-search').each(function () {
            var $search = $(this);
            var nonce =  $search.data('nonce');
            var action =  $search.data('action');
            var url = wc4bp_admin_xprofile_params.ajax_url;
            // Reset field value
            $search.val($search.data('value'));


            // Use select2 to implement intelligent search box
            $search.select2({

                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            action:action,
                            security: $search.data('nonce')
                        };
                    },
                    processResults: function (data) {
                        var terms = [];
                        if (data) {
                            $.each(data, function (id, text) {
                                terms.push({id: id, text: text});
                            });
                        }
                        return {
                            results: terms
                        };
                    },
                    cache: true
                },
                 width: '250px',
                escapeMarkup: function (m) {
                    return m;
                },
                formatSelection: function (data) {
                    return data.text;
                },
                initSelection: function (element, callback) {
                    var selected = [];
                    var data = $.parseJSON(element.attr('data-selected'));
                    var myJSON = JSON.stringify(data);
                    for(var k in data) {

                        selected.push({
                            id: data[k],
                            text: data[k]
                        });
                    }

                  

                    return callback(selected);
                },
                minimumInputLength: 3,
                multiple: true,
                placeholder: $search.data('placeholder')
            });
        });

        //Category

    });

    $('li#group_2,li#group_1,li#group_3').click(function() {
        $(this).siblings().css('background-color', '#dcdcde');
    });
});

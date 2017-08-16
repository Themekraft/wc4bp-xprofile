jQuery(document).ready(function ($) {

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
});

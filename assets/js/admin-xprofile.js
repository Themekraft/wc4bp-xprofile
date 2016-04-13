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
                    $container.find('.wc-search').select2('readonly', false);
                    $container.find('.field.cv-products, .field.cv-categories').removeClass('disabled');
                } else {
                    $container.find('.wc-search').select2('readonly', true);
                    $container.find('.field.cv-products, .field.cv-categories').addClass('disabled');
                }
            });
        });

        $container.find('.wc-search').each(function () {
            var $search = $(this);

            // Reset field value
            $search.val($search.data('value'));

            // Use select2 to implement intelligent search box
            $search.select2({
                ajax: {
                    url: wc4bp_admin_xprofile_params.ajax_url,
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term) {
                        return {
                            term: term,
                            action: $search.data('action'),
                            security: $search.data('nonce')
                        };
                    },
                    results: function (data) {
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
                escapeMarkup: function (m) {
                    return m;
                },
                formatSelection: function (data) {
                    return data.text;
                },
                initSelection: function (element, callback) {
                    var selected = [];
                    var data = $.parseJSON(element.attr('data-selected'));

                    $(element.val().split(',')).each(function (i, val) {
                        if (val in data) {
                            selected.push({
                                id: val,
                                text: data[val]
                            });
                        }
                    });

                    return callback(selected);
                },
                minimumInputLength: 3,
                multiple: true,
                placeholder: $search.data('placeholder')
            });
        });
    });
});

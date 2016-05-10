(function($) {
    'use strict';

    var required_fields = ['name', 'surname', 'country'].concat(REQUIRED_FIELDS||[]);

    var $selectedGroup = $('#selected-group'), $selectedCountry = $('#selected-country');

    if($selectedGroup.length)
        $('[name="group"]').val($selectedGroup.val());

    if($selectedCountry.length)
        $('[name="country"]').val($selectedCountry.val());

    $('[type="submit"]').click(function(event) {
        var valid = true;

        var invalidate = function(el) {
            el.addClass('has-error');
            valid = false;
        };

        $('.has-error').removeClass('has-error');

        $.each(required_fields, function(i, name) {
            var $element = $('[name="' + name + '"]');

            if(!$element.val())
                invalidate($element);

            if(name == 'email') {
                if(!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test($element.val()))
                    invalidate($element);
            }
        });

        if(!valid) {
            event.preventDefault();
            return false;
        }
    });
    $.each(required_fields, function(index, val) {
        $('.asterisk.'+val).addClass('displayable');
    });
    
})(jQuery);
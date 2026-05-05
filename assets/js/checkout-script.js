jQuery(document).ready(function($) {
    
    function initShippingSelect2() {
        var cityFields = $('#shipping_city, #billing_city');
        
        if (cityFields.length) {
            cityFields.select2({
                placeholder: 'Αναζητήστε περιοχή (π.χ. Marousi ή Μαρούσι)...',
                allowClear: true,
                width: '100%',
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Μετατροπή αναζήτησης και δεδομένων σε μικρά και χωρίς τόνους
                    var term = params.term.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    var text = data.text.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                    // Αν ο όρος υπάρχει μέσα στο κείμενο (Ελληνικό ή Λατινικό), εμφάνισέ το
                    if (text.indexOf(term) > -1) {
                        return data;
                    }

                    return null;
                }
            });
        }
    }

    initShippingSelect2();

    $(document.body).on('updated_checkout', function() {
        initShippingSelect2();
    });

    $(document.body).on('change', '#shipping_city, #billing_city', function() {
        $('body').trigger('update_checkout');
    });
});
(function($) {
    'use strict';

    $(function() {

        // 1. Λειτουργία Αναζήτησης (Search)
        $(document).on('keyup', '#usp-area-search', function() {
            // Παίρνουμε την τιμή, μικρά γράμματα και χωρίς τόνους
            var searchTerm = $(this).val().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
            
            $('#shipping-areas-table tbody tr').each(function() {
                var areaInput = $(this).find('input[type="text"]').first();
                if (areaInput.length) {
                    // Μετατρέπουμε το κείμενο της γραμμής σε μικρά και χωρίς τόνους για τη σύγκριση
                    var areaName = areaInput.val().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    
                    if (areaName.indexOf(searchTerm) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            });
        });

        
        $('#add-area-row').on('click', function(e) {
            e.preventDefault();
            
            var rowCount = $('#shipping-areas-table tbody tr').length;
            var row = `<tr>
                <td><input type="text" name="usp_shipping_data[${rowCount}][name]" class="regular-text" required /></td>
                <td><input type="number" step="0.01" name="usp_shipping_data[${rowCount}][price]" value="0" required /></td>
                <td><button type="button" class="button remove-row" style="color:red;">Διαγραφή</button></td>
            </tr>`;
            
            $('#shipping-areas-table tbody').append(row);

            
            $('#usp-area-search').val('').trigger('keyup');
            $('#shipping-areas-table tbody tr:last input[type="text"]').focus();
        });

        
        $(document).on('click', '.remove-row', function(e) {
            e.preventDefault();
            if (confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την περιοχή;')) {
                $(this).closest('tr').remove();
            }
        });

    });

})(jQuery);
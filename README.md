# WooCommerce Shipping Manager 

Ένα εξειδικευμένο WordPress plugin που αναπτύχθηκε για να προσφέρει δυναμικό υπολογισμό μεταφορικών εξόδων βάζοντας όποιες περιοχές θέλετε.

## Λειτουργίες (Features)

*   Δυναμικός Υπολογισμός Κόστους: Αυτόματη ενημέρωση των μεταφορικών στο checkout ανάλογα με την περιοχή του πελάτη.
*   Custom Admin Interface: Ειδικό μενού στο WordPress Dashboard για τη διαχείριση των ζωνών χρέωσης.
*   Bulk Data Handling: Δυνατότητα Μαζικής Εισαγωγής/Εξαγωγής (CSV Import/Export) για εύκολη διαχείριση μεγάλου όγκου περιοχών και τιμών.
*   Βελτιωμένο UX: Ενσωμάτωση της βιβλιοθήκης Select2 για γρήγορη και φιλική αναζήτηση περιοχών από τον χρήστη.

## Τεχνικά Χαρακτηριστικά (Tech Stack)

*   PHP (Object-Oriented): Ο κώδικας είναι οργανωμένος σε κλάσεις για μέγιστη επεκτασιμότητα και καθαρότητα.
*   WordPress/WooCommerce Hooks: Χρήση Actions και Filters για την παρέμβαση στη ροή του checkout.
*   JavaScript (jQuery): Για την αλληλεπίδραση στο frontend και τη σύνδεση με το Select2 API.
*   Data Security: Χρήση WordPress Nonces και Data Sanitization για την ασφάλεια των δεδομένων στην πλευρά του διαχειριστή.

## Δομή Αρχείων (File Structure)

*   `my-shipping-manager.php`: Το κύριο αρχείο που αρχικοποιεί το plugin.
*   `includes/class-ds-checkout.php`: Υπολογισμός των μεταφορικών και τα hooks του checkout.
*   `includes/class-ds-admin.php`: Η διαχείριση του admin menu και των ρυθμίσεων.
*   `includes/class-ds-settings`: Διαχειρίζεται την αποθήκευση και ανάκτηση των ρυθμίσεων του plugin στη βάση δεδομένων του WordPress
*   `assets/`: Περιέχει τα απαραίτητα αρχεία CSS και JavaScript.

## Εγκατάσταση

1. Ανεβάστε τον φάκελο `my-shipping-manager` στον κατάλογο `/wp-content/plugins/`.
2. Ενεργοποιήστε το plugin από το μενού 'Πρόσθετα' στο WordPress.
3. Μεταβείτε στο νέο μενού **Shipping Manager** για να εισάγετε τις ζώνες χρέωσης μέσω CSV ή και χειροκίνητα.
4. ΠΡΟΣΟΧΉ! Για τη σωστή λειτουργία του plugin, θα πρέπει να έχετε ενεργοποιημένη τουλάχιστον μία μέθοδο αποστολής "Σταθερή τιμή" (Flat Rate) στις ρυθμίσεις του WooCommerce (Shipping Zones).

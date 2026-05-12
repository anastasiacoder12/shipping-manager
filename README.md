# WooCommerce Shipping Manager 

Ένα εξειδικευμένο WordPress plugin που αναπτύχθηκε για να προσφέρει δυναμικό υπολογισμό μεταφορικών εξόδων βάζοντας όποιες περιοχές θέλετε.

## Λειτουργίες 

*   Δυναμικός Υπολογισμός Κόστους: Αυτόματη ενημέρωση των μεταφορικών στο checkout ανάλογα με την περιοχή του πελάτη.
*   Custom Admin Interface: Ειδικό μενού στο WordPress Dashboard για τη διαχείριση των ζωνών χρέωσης.
*   Bulk Data Handling: Δυνατότητα Μαζικής Εισαγωγής/Εξαγωγής (CSV Import/Export) για εύκολη διαχείριση μεγάλου όγκου περιοχών και τιμών.
*   Βελτιωμένο UX: Ενσωμάτωση της βιβλιοθήκης Select2 για γρήγορη και φιλική αναζήτηση περιοχών από τον χρήστη.

## Τεχνικά Χαρακτηριστικά

*   PHP : Ο κώδικας είναι οργανωμένος σε κλάσεις για επεκτασιμότητα και καθαρότητα.
*   WordPress/WooCommerce Hooks: Χρήση Actions και Filters για την παρέμβαση στη ροή του checkout.
*   JavaScript : Για την αλληλεπίδραση στο frontend και τη σύνδεση με το Select2 API.
*   Data Security: Χρήση WordPress Nonces και Data Sanitization για την ασφάλεια των δεδομένων στην πλευρά του διαχειριστή.

## Δομή Αρχείων 

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

# ENGLISH

WordPress plugin developed to offer dynamic calculation of shipping costs by setting any areas you want.


## Features

* Dynamic Cost Calculation: Automatically update shipping costs at checkout according to the customer's area.
* Custom Admin Interface: Special menu in the WordPress Dashboard for managing charging zones.
* Bulk Data Handling: Bulk Import/Export capability (CSV Import/Export) for easy management of large volumes of areas and prices.
* Improved UX: Integration of the Select2 library for fast and user-friendly area search.


## Tech Stack

* PHP: The code is organized into classes for extensibility and clarity.
* WordPress/WooCommerce Hooks: Use Actions and Filters to intervene in the checkout flow.
* JavaScript: For frontend interaction and connection to the Select2 API.
* Data Security: Use WordPress Nonces and Data Sanitization for data security on the admin side.


## File Structure

* `my-shipping-manager.php`: The main file that initializes the plugin.
* `includes/class-ds-checkout.php`: Shipping calculation and checkout hooks.
* `includes/class-ds-admin.php`: Admin menu and settings management.
* `includes/class-ds-settings`: Manages saving and retrieving plugin settings in the WordPress database.
* `assets/`: Contains the necessary CSS and JavaScript files.


## Installation

1. Upload the `my-shipping-manager` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin from the 'Plugins' menu in WordPress.
3. Go to the new **Shipping Manager** menu to import the shipping zones via CSV or manually.
4. ATTENTION! For the plugin to work properly, you must have at least one shipping method "Flat Rate" enabled in the WooCommerce settings (Shipping Zones).

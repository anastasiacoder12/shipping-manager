<?php

class DS_Admin {

    public function __construct() {
        // Δημιουργία του μενού στην αριστερή μπάρα
        add_action( 'admin_menu', [ $this, 'add_usp_menu' ] );
        
        // Σύνδεση του CSS αρχείου 
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
        
        // Χειρισμός του CSV Export & Import 
        add_action( 'admin_init', [ $this, 'handle_csv_export' ] );
        add_action( 'admin_init', [ $this, 'handle_csv_import' ] );

        
        add_filter('option_page_capability_usp_group', [$this, 'allow_editor_to_save']);


    }

    
    public function allow_editor_to_save($capability)
    {
        return 'edit_posts'; 
    }

    /**
     * Προσθήκη επιλογής "Shipping Manager" 
     */
    public function add_usp_menu() {
        add_menu_page(
            'Shipping Areas', 
            'Shipping Manager', 
            'edit_posts', 
            'usp-shipping', 
            [ $this, 'render_admin_page' ], 
            'dashicons-location-alt'
        );
    }

    //ΦΟΡΤΩΝΟΥΜΕ CSS & JS

    public function enqueue_admin_assets( $hook ) {
    if ( 'toplevel_page_usp-shipping' !== $hook ) return;

    wp_enqueue_style( 'usp-admin-css', USP_URL . 'assets/css/admin-style.css' );
    
    
    wp_enqueue_script( 'usp-admin-js', USP_URL . 'assets/js/admin-script.js', array('jquery'), '1.0', true );
}

    /**
     * Σελίδα με τα Tabs
     */
    
    public function render_admin_page() {
    $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'areas';
    
    // Εμφάνιση μηνύματος επιτυχίας μετά από Import
    $import_count = get_transient( 'usp_import_success' );
    if ( $import_count ) {
        echo '<div class="updated"><p>✅ Η εισαγωγή ολοκληρώθηκε! Προστέθηκαν ' . $import_count . ' περιοχές.</p></div>';
        delete_transient( 'usp_import_success' );
    }
    ?>
    <div class="wrap">
        <h1>📦 Διαχείριση Μεταφορικών</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=usp-shipping&tab=areas" class="nav-tab <?php echo $active_tab == 'areas' ? 'nav-tab-active' : ''; ?>">Περιοχές & Τιμές</a>
            <a href="?page=usp-shipping&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">Γενικές Ρυθμίσεις</a>
        </h2>

        <div class="usp-tab-content">
            <?php if ( $active_tab == 'areas' ) : ?>
                
                <div class="usp-import-section" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
                    <h4 style="margin-top:0;">📥 Μαζική Εισαγωγή από CSV</h4>
                    <form method="post" enctype="multipart/form-data" action="">
                        <?php wp_nonce_field( 'usp_csv_import_action', 'usp_csv_import_nonce' ); ?>
                        <input type="file" name="usp_import_file" accept=".csv" required />
                        <input type="submit" name="usp_import_submit" class="button button-secondary" value="Εισαγωγή Περιοχών">
                        <p class="description">Ανεβάστε το CSV για να αντικαταστήσετε τις περιοχές σας.</p>
                    </form>
                </div>

                <hr>

                <form method="post" action="options.php">
                    <?php settings_fields( 'usp_group' ); ?>
                    
                    <h3>Περιοχές Παράδοσης</h3>

                    <div style="background: #fff; padding: 10px; border: 1px solid #ccd0d4; margin-bottom: 15px;">
                        <strong>🔍 Αναζήτηση: </strong> 
                        <input type="text" id="usp-area-search" placeholder="Ξεκινήστε να πληκτρολογείτε (π.χ. αθηνα)..." style="width: 350px; padding: 8px;">
                    </div>

                    <table class="wp-list-table widefat fixed striped" id="shipping-areas-table">
                        <thead>
                            <tr>
                                <th>Όνομα Περιοχής / Νοσοκομείου</th>
                                <th style="width:150px;">Κόστος (€)</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $areas = DS_Settings::get_areas();
                            if ( !empty($areas) ) : 
                                foreach ( $areas as $idx => $row ) : ?>
                                <tr>
                                    <td><input type="text" name="usp_shipping_data[<?php echo $idx; ?>][name]" value="<?php echo esc_attr($row['name']); ?>" style="width:100%;" /></td>
                                    <td><input type="number" step="0.01" name="usp_shipping_data[<?php echo $idx; ?>][price]" value="<?php echo esc_attr($row['price']); ?>" style="width:100%;" /></td>
                                    <td><button type="button" class="remove-row button">X</button></td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    
                    <div style="margin-top:15px; display:flex; gap:10px;">
                        <button type="button" id="add-area-row" class="button button-secondary">+ Προσθήκη</button>
                        <a href="<?php echo admin_url('admin.php?page=usp-shipping&action=usp_export_csv'); ?>" class="button button-primary">📥 Εξαγωγή σε CSV</a>
                    </div>

                    <div style="margin-top:30px;">
                        <?php submit_button('Αποθήκευση Πίνακα'); ?>
                    </div>
                </form>

            <?php else : ?>
                
                <form method="post" action="options.php">
                    <?php settings_fields( 'usp_group' ); ?>
                    <h3>Ρυθμίσεις Συστήματος</h3>
                    <?php $config = DS_Settings::get_config(); ?>
                    <table class="form-table">
                        <tr>
                            <th>Default Κόστος:</th>
                            <td>
                                <input type="number" step="0.01" name="usp_general_config[default_price]" value="<?php echo esc_attr($config['default_price'] ?? '5.00'); ?>" />
                                <p class="description">Αυτό το ποσό θα χρεώνεται αν ο πελάτης δεν επιλέξει περιοχή.</p>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('Αποθήκευση Ρυθμίσεων'); ?>
                </form>

            <?php endif; ?>
        </div>
    </div>
    <?php
}

    public function handle_csv_export() {
    
    if ( ! isset( $_GET['action'] ) || $_GET['action'] !== 'usp_export_csv' ) {
        return;
    }

    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( 'Δεν έχετε δικαιώματα πρόσβασης σε αυτή τη σελίδα.' );
    }

    // Παίρνουμε τα δεδομένα των περιοχών
    $areas = DS_Settings::get_areas();

    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=shipping-areas-' . date('Y-m-d') . '.csv');

    
    $output = fopen('php://output', 'w');

  

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=shipping-areas-' . date('Y-m-d') . '.csv');

    $output = fopen('php://output', 'w');

    // Προσθέτει το UTF-8 BOM
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));


    
    fputcsv($output, ['Περιοχή', 'Τιμή']);

    
    if ( ! empty( $areas ) ) {
        foreach ( $areas as $row ) {
            fputcsv($output, [ $row['name'], $row['price'] ]);
        }
    }

    fclose($output);
    exit; 
}

public function handle_csv_import() {
    
    if ( ! isset( $_POST['usp_import_submit'] ) || empty( $_FILES['usp_import_file']['tmp_name'] ) ) {
        return;
    }

    
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( 'Δεν έχετε επαρκή δικαιώματα για αυτή την ενέργεια.' );
    }

    // NONCE 
    if ( ! isset( $_POST['usp_csv_import_nonce'] ) || ! wp_verify_nonce( $_POST['usp_csv_import_nonce'], 'usp_csv_import_action' ) ) {
        wp_die( 'Σφάλμα ασφαλείας (Nonce verification failed).' );
    }

    
    $file = $_FILES['usp_import_file']['tmp_name'];
    $new_areas = [];

    $file = $_FILES['usp_import_file']['tmp_name'];
    $new_areas = [];

    
    $content = file_get_contents($file);
    
    
    $content = str_replace("\xEF\xBB\xBF", '', $content);

    
    $lines = preg_split('/\r\n|\r|\n/', $content);

    if ( ! empty( $lines ) ) {
        foreach ( $lines as $index => $line ) {
            
            if ( $index === 0 || empty( trim($line) ) ) continue;

            
            $data = strpos($line, ';') !== false ? explode(';', $line) : explode(',', $line);

            if ( count($data) >= 2 ) {
                
                $name  = sanitize_text_field( trim( str_replace('"', '', $data[0]) ) );
                $price = floatval( str_replace(['"', ','], ['', '.'], trim($data[1])) );

                if ( ! empty( $name ) ) {
                    $new_areas[] = [
                        'name'  => $name,
                        'price' => $price
                    ];
                }
            }
        }
    }

    if ( ! empty( $new_areas ) ) {
        
        update_option( 'usp_shipping_data', $new_areas );
        
       
        set_transient( 'usp_import_success', count($new_areas), 30 );
        
        
        wp_redirect( admin_url( 'admin.php?page=usp-shipping&tab=areas' ) );
        exit;
    }
}

}
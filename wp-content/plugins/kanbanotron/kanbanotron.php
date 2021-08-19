 <?php
    /**
     * Plugin Name: Kanbanotron
     * Description: A plugin specifically designed for use by Inventive-Group, that creates a fully automated system of re-ordering kanbans.
     * Version: 1.0
     * Requires at least: 5.7
     * Requires PHP: 8.0
     * Author: Andrew Foster
     */

    define('WPFP_PATH', plugin_dir_path(__FILE__));

    // Registers a new custom post type for Kanbans.
    function knbn_custom_post_type()
    {
        register_post_type('knbn_action', array(
            'labels' => array(
                'name' => __('Kanbans', 'textdomain'),
                'singular_name' => __('Kanban', 'textdomain'),
                'add_new' => __('Create New', 'textdomain'),
                'add_new_item' => __('Create New Kanban', 'textdomain'),
                'edit_item' => __('Edit Kanban', 'textdomain'),
                'new_item' => __('New Kanban', 'textdomain'),
                'view_item' => __('View Kanban', 'textdomain'),
                'view_items' => __('View Kanbans', 'textdomain'),
                'search_items' => __('Search Kanbans', 'textdomain'),
                'not_found' => __('No Kanbans Found', 'textdomain'),
                'not_found_in_trash' => __('No Kanbans Found in Trash', 'textdomain'),
                'parent_item_colon' => __('Parent Kanban', 'textdomain'),
                'all_items' => __('All Kanbans', 'textdomain'),
                'archives' => __('Kanban Archives', 'textdomain'),
                'attributes' => __('Kanban Attributes', 'textdomain'),
                'insert_into_item' => __('Insert Into Kanban', 'textdomain'),
                'uploaded_to_this_item' => __('Uploaded to this Kanban', 'textdomain'),
                'filter_items_list' => __('Filter Kanbans List', 'textdomain'),
                'item_published' => __('Kanban Published', 'textdomain'),
                'item_published_privately' => __('Kanban Published Privately', 'textdomain'),
                'item_reverted_to_draft' => __('Kanban Reverted to draft', 'textdomain'),
                'item_scheduled' => __('Kanban Scheduled', 'textdomain'),
                'item_updated' => __('Kanban Updated', 'textdomain'),
            ),
            'public' => true,
            'has_archive' => true,
        ));
    }
    add_action('init', 'knbn_custom_post_type');

    // Adds an option page for importing kanbans

    // create custom plugin settings menu
    add_action('admin_menu', 'kanbanotron_create_menu');

    // Hides csv_update page from backend of wordpress
    add_action('admin_head', function () {
        remove_submenu_page('edit.php?post_type=knbn_action', 'csv_update');
    });

    function kanbanotron_create_menu()
    {
        //create new sub menu
        add_submenu_page('edit.php?post_type=knbn_action', 'Update Kanbans', 'Update Kanbans', 'administrator', 'update_kanbans', 'kanbanotron_import_kanbans_page');

        //create new sub menu that will be hidden for updating csv's
        add_submenu_page('edit.php?post_type=knbn_action', 'csv_update', 'csv_update', 'administrator', 'csv_update', 'kanbanotron_import_csv_update_page');

        //call register settings function
        add_action('admin_init', 'register_kanbanotron_settings');
    }

    function kanbanotron_import_kanbans_page()
    {
        include 'admin/update_kanbans.php';
    }

    function kanbanotron_import_csv_update_page()
    {
        include 'admin/components/csv_update.php';
    }

    add_filter('mime_types', 'wpse_mime_types');
    function wpse_mime_types($existing_mimes)
    {
        // Add csv to the list of allowed mime types
        $existing_mimes['csv'] = 'text/csv';

        return $existing_mimes;
    }

    /**
     * Updates post meta for a post. It also automatically deletes or adds the value to field_name if specified
     *
     * @access     protected
     * @param      integer     The post ID for the post we're updating
     * @param      string      The field we're updating/adding/deleting
     * @param      string      [Optional] The value to update/add for field_name. If left blank, data will be deleted.
     * @return     void
     */

    function __update_post_meta($post_id, $field_name, $value = '')
    {
        if (empty($value) or !$value) {
            delete_post_meta($post_id, $field_name);
        } elseif (!get_post_meta($post_id, $field_name)) {
            add_post_meta($post_id, $field_name, $value);
        } else {
            update_post_meta($post_id, $field_name, $value);
        }
    }

    // Custom Scripts
    add_action('wp_enqueue_scripts', 'custom_scripts');
    function custom_scripts()
    {
        wp_enqueue_script('kanbanotron', plugin_dir_url(__FILE__) . 'js/kanbanotron.js', array('jquery'));
    }

    // Custom Admin Scripts
    add_action('admin_enqueue_scripts', 'custom_admin_scripts');
    function custom_admin_scripts()
    {
        wp_enqueue_script('knbn_admin.js', plugin_dir_url(__FILE__) . 'admin/js/knbn_admin.js', array('jquery'), false, true);

        wp_enqueue_style('admin.css', plugin_dir_url(__FILE__) . 'admin/admin.css', false, false);
    }

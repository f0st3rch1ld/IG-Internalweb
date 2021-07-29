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

    function kanbanotron_create_menu()
    {
        //create new sub menu
        add_submenu_page('edit.php?post_type=knbn_action', 'Import Kanbans', 'Import Kanbans', 'administrator', 'import_kanbans', 'kanbanotron_import_kanbans_page');

        //call register settings function
        add_action('admin_init', 'register_kanbanotron_settings');
    }

    function register_kanbanotron_settings()
    {
        //register our settings
        register_setting('kanbanotron_settings_group', 'upload-csv');
        register_setting("kanbanotron_settings_group", "csv", "handle_csv_upload");
    }

    function kanbanotron_import_kanbans_page()
    {
        include 'admin/import_kanbans.php';
    }


    function handle_csv_upload($option)
    {
        if (!empty($_FILES["csv"]["tmp_name"])) {
            $urls = wp_handle_upload($_FILES["csv"], array('test_form' => FALSE));
            $temp = $urls["url"];
            return $temp;
        }

        return $option;
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

    // Custom Header Scripts
    add_action('wp_enqueue_scripts', 'custom_header_scripts');
    function custom_header_scripts()
    {
        wp_enqueue_script('kanbanotron', plugin_dir_url(__FILE__) . 'js/kanbanotron.js', array('jquery'));
    }

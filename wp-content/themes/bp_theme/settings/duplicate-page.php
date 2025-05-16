<?php
// Function to duplicate a post as a draft
function duplicate_post_as_draft($post_id) {
	// Check if the post exists
	if (!isset($post_id)) {
		return;
	}

	// Get the original post
	$post = get_post($post_id);
	if (empty($post) || $post->post_type != 'page') {
		return; // Exit if post doesn't exist or is not a page
	}

	// Prepare a new post object
	$new_post = array(
		'post_title'    => $post->post_title . ' (Copy)', // Add " (Copy)" to the title
		'post_content'  => $post->post_content,
		'post_status'   => 'draft', // Set status to draft
		'post_type'     => 'page',
		'post_author'   => $post->post_author,
		'post_excerpt'  => $post->post_excerpt,
		'post_date'     => current_time('mysql'),
		'post_date_gmt' => current_time('mysql', 1),
		'page_template' => get_post_meta($post_id, '_wp_page_template', true), // Include page template
	);

	// Insert the post into the database
	$new_post_id = wp_insert_post($new_post);

	// Duplicate taxonomy terms if any
	$taxonomies = get_object_taxonomies($post);
	foreach ($taxonomies as $taxonomy) {
		$terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));
		wp_set_object_terms($new_post_id, $terms, $taxonomy);
	}

	// Duplicate post meta
	$post_meta = get_post_meta($post_id);
	foreach ($post_meta as $meta_key => $meta_value) {
		if (strpos($meta_key, '_') === 0) {
			continue; // Exclude default meta keys that start with "_"
		}
		add_post_meta($new_post_id, $meta_key, maybe_unserialize($meta_value[0]));
	}

	// Duplicate custom fields
	$custom_fields = get_post_custom($post_id);
	foreach ($custom_fields as $key => $value) {
		if (strpos($key, '_') === 0) {
			continue; // Exclude default meta keys that start with "_"
		}
		// Make sure to handle arrays
		if (is_array($value)) {
			foreach ($value as $v) {
				add_post_meta($new_post_id, $key, maybe_unserialize($v));
			}
		} else {
			add_post_meta($new_post_id, $key, maybe_unserialize($value));
		}
	}

	return $new_post_id;
}

// Function to register the duplicate page action
function register_duplicate_page_action() {
	// Check if we have a post ID in the URL
	if (isset($_GET['action']) && $_GET['action'] == 'duplicate_page' && isset($_GET['post'])) {
		// Duplicate the page
		$new_page_id = duplicate_post_as_draft($_GET['post']);
		if ($new_page_id) {
			// Redirect to the new page edit screen
			wp_redirect(admin_url('post.php?action=edit&post=' . $new_page_id));
			exit;
		}
	}
}
add_action('admin_action_duplicate_page', 'register_duplicate_page_action');

// Function to add the duplicate page link to the page actions
function add_duplicate_page_link($actions, $post) {
	// Only add the link to pages
	if ($post->post_type == 'page') {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=duplicate_page&post=' . $post->ID, 'duplicate_page_nonce') . '" title="Duplicate this page" rel="permalink">Duplicate</a>';
	}
	return $actions;
}
add_filter('page_row_actions', 'add_duplicate_page_link', 10, 2);
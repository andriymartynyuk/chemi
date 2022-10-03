<?php

namespace ElementPack\Includes;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
class EP_Duplicator {
	public function __construct() {
		add_action('admin_action_ep_duplicate_as_draft', [$this, 'ep_duplicate_as_draft']);
		add_filter('post_row_actions', [$this, 'ep_duplicate_post_link'], 10, 2);
		add_filter('page_row_actions', [$this, 'ep_duplicate_post_link'], 10, 2);
	}

	public function ep_duplicate_as_draft() {
		global $wpdb;

		if (!(isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'ep_duplicate_as_draft' == $_REQUEST['action']))) {
			wp_die('No post to duplicate has been supplied!');
		}
		/*
		* Nonce verification
		*/
		if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__))) {
			return;
		}
		/*
         * get the original post id
         */
		$ep_post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
		/*
         * and all the original post data then
         */
		$ep_post = get_post($ep_post_id);
		/*
         * if you don't want current user to be the new post author,
         * then change next couple of lines to this: $new_post_author = $post->post_author;
         */
		$ep_current_user    = wp_get_current_user();
		$ep_new_post_author = $ep_current_user->ID;

		/*
		* if post data exists, create the post duplicate
		*/
		if (isset($ep_post) && $ep_post != null) {
			/*
             * new post data array
             */
			$ep_args = [
				'comment_status' => $ep_post->comment_status,
				'ping_status'    => $ep_post->ping_status,
				'post_author'    => $ep_new_post_author,
				'post_content'   => $ep_post->post_content,
				'post_excerpt'   => $ep_post->post_excerpt,
				'post_name'      => $ep_post->post_name,
				'post_parent'    => $ep_post->post_parent,
				'post_password'  => $ep_post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $ep_post->post_title,
				'post_type'      => $ep_post->post_type,
				'to_ping'        => $ep_post->to_ping,
				'menu_order'     => $ep_post->menu_order,
			];

			/*
             * insert the post by wp_insert_post() function
             */
			$ep_new_post_id = wp_insert_post($ep_args);

			/*
             * get all current post terms ad set them to the new post draft
             */
			$ep_taxonomies = get_object_taxonomies($ep_post->post_type);
			// returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($ep_taxonomies as $ddp_taxonomy) {
				$ep_post_terms = wp_get_object_terms($ep_post_id, $ddp_taxonomy, ['fields' => 'slugs']);
				wp_set_object_terms($ep_new_post_id, $ep_post_terms, $ddp_taxonomy, false);
			}

			/*
             * duplicate all post meta just in two SQL queries
             */
			$ep_post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$ep_post_id");
			if (count($ep_post_meta_infos) != 0) {
				$ep_sql_query = esc_sql("INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ");

				foreach ($ep_post_meta_infos as $ep_meta_info) {
					$ep_meta_key = $ep_meta_info->meta_key;

					if ($ep_meta_key == '_wp_old_slug') {
						continue;
					}

					$ep_meta_value      = addslashes($ep_meta_info->meta_value);
					$ep_sql_query_sel[] = esc_sql("SELECT $ep_new_post_id, '$ep_meta_key', '$ep_meta_value'");
				}

				$ep_sql_query .= implode(" UNION ALL ", $ep_sql_query_sel);
				$wpdb->query($ep_sql_query);
			}

			/*
             * finally, redirect to the edit post screen for the new draft
             */

			$ep_all_post_types = get_post_types([], 'names');

			foreach ($ep_all_post_types as $ep_key => $ep_value) {
				$ep_names[] = $ep_key;
			}
			$ep_current_post_type = get_post_type($ep_post_id);

			if (is_array($ep_names) && in_array($ep_current_post_type, $ep_names)) {
				wp_redirect(admin_url('edit.php?post_type=' . $ep_current_post_type));
			}
			exit;
		} else {
			wp_die('Failed. Not Found Post: ' . $ep_post_id);
		}
	}

	public function ep_duplicate_post_link($actions, $post) {
		if ((current_user_can('edit_posts')) && ($post->post_type == 'post')) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=ep_duplicate_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this post" rel="permalink">Duplicate Post</a>';
		} else if ((current_user_can('edit_posts')) && ($post->post_type == 'page')) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=ep_duplicate_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this page" rel="permalink">Duplicate Page</a>';
		} else if ((current_user_can('edit_posts')) && ($post->post_type == 'elementor_library')) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=ep_duplicate_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this template" rel="permalink">Duplicate Template</a>';
		}
		return $actions;
	}
}
new EP_Duplicator();

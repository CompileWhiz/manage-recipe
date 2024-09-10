<?php

namespace Recipe_Manager\Includes;

defined('ABSPATH') || die();

class Recipe_CPT {
	public function __construct() {
		add_action('init', [$this, 'recipe_post_type']);
		add_action('init', [$this, 'register_cat_type_taxonomy']);
		add_action('add_meta_boxes', [$this, 'add_recipes_gallery_meta_box']);
		add_action('save_post', [$this, 'save_recipes_gallery_meta_box']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('admin_footer', [$this, 'inline_media_script']);
		// Hook into 'template_include' to load custom template

		add_filter('template_include', [$this, 'load_custom_post_template']);
	}

	public function recipe_post_type() {
		$labels = array(
			'name'               => _x('Recipes', 'Post Type General Name', 'recipe-manager'),
			'singular_name'      => _x('Recipe', 'Post Type Singular Name', 'recipe-manager'),
			'menu_name'          => __('Recipes', 'recipe-manager'),
			'name_admin_bar'     => __('Recipe', 'recipe-manager'),
			'add_new_item'       => __('Add New Recipe', 'recipe-manager'),
			'new_item'           => __('New Recipe', 'recipe-manager'),
			'edit_item'          => __('Edit Recipe', 'recipe-manager'),
			'view_item'          => __('View Recipe', 'recipe-manager'),
			'all_items'          => __('All Recipes', 'recipe-manager'),
			'search_items'       => __('Search Recipes', 'recipe-manager'),
			'not_found'          => __('No recipes found', 'recipe-manager'),
			'not_found_in_trash' => __('No recipes found in Trash', 'recipe-manager'),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'rewrite'            => array('slug' => 'recipes'),
			'supports'           => array('title', 'editor', 'thumbnail'),
			'show_in_rest'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-carrot', // Optional icon for the post type
		);

		register_post_type('recipes', $args);
	}


	public function register_cat_type_taxonomy() {
		$toxa_labels = [
			'name'              => __('Categories', 'recipe-manager'),
			'singular_name'     => __('Category', 'recipe-manager'),
			'search_items'      => __('Search Categories', 'recipe-manager'),
			'all_items'         => __('All Categories', 'recipe-manager'),
			'parent_item'       => __('Parent Category', 'recipe-manager'),
			'parent_item_colon' => __('Parent Category:', 'recipe-manager'),
			'edit_item'         => __('Edit Category', 'recipe-manager'),
			'update_item'       => __('Update Category', 'recipe-manager'),
			'add_new_item'      => __('Add New Category', 'recipe-manager'),
			'new_item_name'     => __('New Category Name', 'recipe-manager'),
			'menu_name'         => __('Categories', 'recipe-manager'),
		];
		register_taxonomy('_categories', ['recipes'], [
			'hierarchical'      => true,
			'labels'            => $toxa_labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'rewrite'           => ['slug' => '_categories'],
		]);
	}

	// Add Gallery Meta Box to Custom Post Type
	public function add_recipes_gallery_meta_box() {
		add_meta_box(
			'recipes_gallery',
			__('Gallery', 'recipe-manager'),
			[$this, 'recipes_gallery_meta_box_callback'],
			'recipes',
			'side',
			'low'
		);
	}

	public function recipes_gallery_meta_box_callback($post) {
		wp_nonce_field('save_recipes_gallery', 'recipes_gallery_nonce');

		$gallery = get_post_meta($post->ID, '_recipes_gallery', true);

		echo '<div id="recipes-gallery-wrapper" style="display: flex; flex-wrap: wrap;">';
		if (!empty($gallery)) {
			foreach ($gallery as $image_id) {
				echo '<div class="recipes-gallery-item" style="margin: 0 5px 10px; position: relative;">';
				echo wp_get_attachment_image($image_id, 'thumbnail', false, array('style' => 'max-width: 100px; height: auto;'));
				echo '<input type="hidden" name="recipes_gallery[]" value="' . esc_attr($image_id) . '">';
				echo '<a href="#" class="remove-image" >&times;</a>';
				echo '</div>';
			}
		}
		echo '</div>';
		echo '<input type="button" id="add-recipes-gallery" value="' . esc_attr__('Add Image', 'recipe-manager') . '" class="button">';
	}

	public function save_recipes_gallery_meta_box($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (!isset($_POST['recipes_gallery_nonce']) || !wp_verify_nonce($_POST['recipes_gallery_nonce'], 'save_recipes_gallery')) {
			return;
		}

		if (isset($_POST['recipes_gallery'])) {
			$gallery = array_map('intval', $_POST['recipes_gallery']);
			update_post_meta($post_id, '_recipes_gallery', $gallery);
		}
	}

	public function enqueue_scripts() {
		global $post_type;
		if ($post_type === 'recipes') {
			wp_enqueue_media();
			wp_enqueue_script('recipes-gallery-script', get_template_directory_uri() . '/js/recipes-gallery.js', ['jquery'], null, true);
		}
	}

	public function inline_media_script() {
		global $post_type;
		if ($post_type === 'recipes') {
?>
			<style>
				a.remove-image {
					text-decoration: none;
					background: white;
					box-shadow: 0 0 15px rgba(0, 0, 0, .5);
					border-radius: 50%;
					height: 18px;
					width: 18px;
					display: flex;
					align-items: center;
					justify-content: center;
					position: absolute;
					right: -5px;
					top: -6px;
					color: red;
				}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('#add-recipes-gallery').click(function(e) {
						e.preventDefault();
						var frame = wp.media({
							title: 'Select Images',
							button: {
								text: 'Add to Gallery'
							},
							multiple: true
						});

						frame.on('select', function() {
							var attachments = frame.state().get('selection').toJSON();
							attachments.forEach(function(attachment) {
								$('#recipes-gallery-wrapper').append(
									'<div class="recipes-gallery-item" style="margin: 0 5px 10px; position: relative;">' +
									'<img src="' + attachment.sizes.thumbnail.url + '" style="max-width: 100px; height: auto;" />' +
									'<input type="hidden" name="recipes_gallery[]" value="' + attachment.id + '">' +
									'<a href="#" class="remove-image" >&times;</a>' +
									'</div>'
								);
							});
						});

						frame.open();
					});

					$('#recipes-gallery-wrapper').on('click', '.remove-image', function(e) {
						e.preventDefault();
						$(this).closest('.recipes-gallery-item').remove();
					});
				});
			</script>
<?php
		}
	}

	public function load_custom_post_template($template) {


		if (is_singular('recipes')) {
			$plugin_template = RECIPE_PLUGIN_DIR . 'templates/single-recipes.php';

			if (file_exists($plugin_template)) {
				return $plugin_template; // Load custom template
			}
		}

		return $template;
	}



}

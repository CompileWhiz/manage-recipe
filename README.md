# Manage Recipe Plugin

## Description

The **Manage Recipe Plugin** allows you to create and manage recipes from the WordPress admin panel, with options to add multiple categories and images for each recipe. On the public side, users can filter and search recipes dynamically, using AJAX for seamless interaction. Clicking on a recipe image opens a modal gallery, and clicking on a recipe link shows detailed recipe information.

### Features

- **Admin Panel**:
    - Add recipes with the following fields: Name, Description, Category, and Multiple Images.
    - Manage categories for easy classification of recipes.
    - Re-save the Permalinks to ensure individual recipe pages are accessible after clicking on a specific recipe.

- **Public View**:
    - Filter recipes by category dynamically.
    - Search recipes by name with instant AJAX results.
    - Modal gallery opens when clicking on a recipe image.
    - Recipe details available by clicking the recipe link.

### Installation

1. Download the plugin and unzip the folder.
2. Upload the unzipped folder to your WordPress site's `wp-content/plugins/` directory.
3. Activate the plugin via the **Plugins** menu in WordPress.

### Usage

#### Admin Panel
- After activation, a new menu item called "Recipes" will appear in the WordPress admin sidebar.
- Add new recipes by navigating to `Recipes > Add New`, where you can fill in the name, description, category, and upload multiple images.
- Manage recipe categories by navigating to `Recipes > Categories`.

#### Frontend
- Use the shortcode `[recipe]` to display the recipe list with filtering and search options on any page.
- Results are updated dynamically using AJAX when filtering by category or searching by name.

### Technical Details

- **Custom Post Type (CPT)**:
    - Registers a custom post type called "recipes" with fields such as title, description, images, and category. This functionality is defined in `includes/cpt.php`.

- **AJAX Filtering and Search**:
    - AJAX is used to provide smooth, dynamic filtering and searching functionality. The corresponding logic is found in `includes/ajax.php`, with the frontend interaction handled by `assets/js/frontend.js`.

- **Shortcodes**:
    - A shortcode `[recipe]` is provided to display the recipe list in the frontend. This is defined in `includes/short-code.php`.

- **Modal Image Gallery**:
    - Clicking on a recipe image opens a modal gallery powered by the Glightbox library (`assets/js/glightbox.min.js`). This allows for a seamless image viewing experience without leaving the page.

### Template Structure

- `single-recipes.php`: Template for displaying individual recipe details.
- `frontend.php`: Template for rendering the recipe list with filtering and search.
- `recipe.php`: Template for rendering individual recipes in the list.

### Assets

- **CSS**:
    - Styles for the frontend and modal galleries are handled in `assets/css/public.css`, `assets/css/slick.css`, and `assets/css/glightbox.min.css`.

- **JavaScript**:
    - AJAX and frontend interactions are managed by `assets/js/frontend.js`, `assets/js/slick.min.js`, and `assets/js/glightbox.min.js`.

### Database

The plugin stores recipes and categories using the default WordPress post and taxonomy tables.

To share your database or migrate the site, export your database tables related to the `recipes` custom post type.

### License

This plugin is licensed under The GNU General Public License v3.0.


# Snoka Extra Menu Attributes Plugin

## Description
The **Snoka Extra Menu Attributes** plugin enhances WordPress navigation menus by allowing you to add `data-target` attributes and custom classes to individual menu items. This feature provides additional flexibility for theme developers and site administrators to tailor navigation menu behavior and styling.

## Features
- **Data Target Attribute**: Add custom `data-target` attributes to your menu items for use in JavaScript interactions or CSS styling.
- **Custom Class**: Append custom classes to your menu items to facilitate more specific styling or to target them with JavaScript.

## Installation
1. Download the plugin files and upload them to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage
After activation, navigate to the **Appearance > Menus** section in your WordPress dashboard. When editing a menu, you will see options to add a `data-target` attribute and custom classes to each menu item.

### Adding Data Target and Custom Classes
1. Go to **Appearance > Menus** and select a menu to edit.
2. Expand a menu item to see the custom options.
3. Enter values for the `Data Target` and `Custom Class` fields as needed.
4. Save the menu.

## Hooks and Filters
This plugin hooks into the `wp_nav_menu_item_custom_fields` to add the custom fields for data target and custom class. It uses `wp_update_nav_menu_item` for saving the custom field values and `nav_menu_link_attributes` to apply them to the front end.

## License
This plugin is licensed under the GNU General Public License v2 or later. For more details, see the license URI: http://www.gnu.org/licenses/gpl-2.0.html

## Author Information
Developed by Snoka Media. Visit us at [https://snoka.ca](https://snoka.ca) for more information and other WordPress resources.

## Contributions
Contributions to the plugin are welcome. Please ensure any pull requests or issues adhere to the WordPress coding standards and are thoroughly tested.

## Support
For support, please visit the plugin's website or contact Snoka Media directly through their website.

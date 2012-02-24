=== Plugin Name ===
Contributors: Saleh_Coder, SalehCoder
Donate link: 
Tags: people, list, academic, alumni, research, university, college, school, plugin, wordpress, academic profile, profile, users
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 0.1.0

Provides the ability to profile users academically and create categories of academic people. You can also show Academic people list using shortcode.

== Description ==

With this plugin you can now use WordPress effectively for a research group website or alumni website by associating additional academic information to selected users. 

You can create categories of academic people. For example, your research group has a group for 'social network research' and another group for 'A.I. neurological research', and you want to list people working on each group seperately. That's now possible with this plugin.

Users can attach all of the following details to their accounts:

*	Academic phone number
*	Website 
*	Academic email 
*	Current job 
*	Bachelore degree area, institution, and year
*	Master degree area, institution, and year
*	Ph.D. area, institution, and year 
*	Academic biography
*	Address

Admin will have to explicitly select users and upgrade them to academic users. Those users will be able to edit their academic profiles accordingly by accessing the 'wp-admin/' directly.

To show academic users you will have to use '[academic-people-list]' shortcode in any page or post. Optionally, you can specify the 'category' and 'show_cat' attributes. Here is how to use it:

*	[academic-people-list]: All users from all academic categories and will show list of categories
*	[academic-people-list category='CATEGORY 1' show_cat='false']: Users from CATEGORY 1 and will not show list of categories
*	[academic-people-list category='Group A']: Users from Group A and will show list of categories

For profile pictures to work correctly, you'll have to use the [User Photo plugin](http://wordpress.org/extend/plugins/user-photo/ "User Photo plugin") 

This plugin is still under development and many other features are yet to be developed.

== Installation ==

1. Upload the wp-academic-people folder to your /wp-content/plugins/ directory
2. Activate the plugin using the Plugins menu in WordPress
3. On the Admin panel, use the Academic People menu to adjust the plugin
4. Adjust the WP->Twitter Options as you prefer. 
5. That's it! You're all set.







POTS-Site
=========

1.- Upload all files to the final destination server running LAMP Linux(i recommend), Apache, MySQL, PHP.
2.- Configure wp-config.php with the credentials of your server configuration (Database Name, User, Password, Localhost, etc)
3.- Upload the database placeholder data (see INFO/SQL)
4.- Execute your [root_site_URL]/sr.php and follow the instructions and replace the database placeholder URL (dev.pots.com) for your final URL. This is for change the site URL and all work well in the Wordpress configuration. (wordpress works with the site URL saved in the database).
5.- Enter to [root_site_URL]/wp-admin/options-permalink.php and click in save option, this is to make works all URL's: flush!.
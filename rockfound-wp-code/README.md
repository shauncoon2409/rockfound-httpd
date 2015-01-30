## Documentation

### Intallation
1. Be sure that all dependencies are installed. Clone down the repository.
2. Run `composer install` This should download all plugins in `/html/app/mu-plugins` and `/html/app/plugins`, and create wordpress in the `/html/wp` directory.
3. Run `vagrant up` This will create a vagrant enviornment for local development.
4. After vagrant has completed installing and the server has started create and import `rocke.sql`. See [Connecting to local database](#connecting-to-local-database). (It's suggested to use Sequel Pro.)
5. Copy the .env.example file and rename it .env and add your local credentials and salts. 
6. You should now be able to browse to [rockefeller.local](http://rockefeller.local) and see the site. If this doesn't work, be sure the entry was added to your hosts file.
8. For theme development, go to `/html/app/themes/` and run `bundle install`, `npm install`, and then `npm start`
9. This should install all dependencies and start the gulp watch file.


#### Dependencies
* [Vagrant](https://docs.vagrantup.com/v2/installation/index.html) (virtualbox)
* [Composer](https://getcomposer.org/doc/00-intro.md)
* [Bundler](http://bundler.io/)
* [node.js](http://nodejs.org/)


### Folder Structure

```
├── composer.json
├── config
│   ├── environments
│   │   ├── development.php
│   │   ├── staging.php
│   │   └── production.php
│   └── application.php
├── vendor
└── html
    ├── app
    │   ├── mu-plugins
    │   ├── plugins
    │   ├── themes
    │   └── uploads
    ├── wp-config.php
    ├── index.php
    └── wp
```

The organization is similar to putting WordPress in its own subdirectory but with some improvements.

* In order not to expose sensetive files in the webroot, Bedrock moves what's required into a `html/` directory including the vendor'd `wp/` source, and the `wp-content` source.
* `wp-content` (or maybe just `content`) has been named `app` to better reflect its contents. It contains application code and not just "static content". It also matches up with other frameworks such as Symfony and Rails.
* `wp-config.php` remains in the `html/` because it's required by WP, but it only acts as a loader. The actual configuration files have been moved to `config/` for better separation.
* `vendor/` is where the Composer managed dependencies are installed to.
* `wp/` is where the WordPress core lives. It's also managed by Composer but can't be put under `vendor` due to WP limitations.


### Connecting to local database
Database Name:		(leave blank)
Database User:		root
Database Password:	root
Database Host:		localhost
SSH Host:			192.168.33.11 (should match $ip in Vagrantfile)
SSH User:			vagrant
SSH Password:		vagrant


### Configuration Files

The root `web/wp-config.php` is required by WordPress and is only used to load the other main configs. Nothing else should be added to it.

`config/application.php` is the main config file that contains what `wp-config.php` usually would. Base options should be set in there.

For environment specific configuration, use the files under `config/environments`.

The environment configs are required **before** the main `application` config so anything in an environment config takes precedence over `application`.


### Environment Variables

The goal is to separate config from code as much as possible and environment variables are used to achieve this. The benefit is there's a single place (`.env`) to keep settings like database or other 3rd party credentials that isn't committed to your repository.

[PHP dotenv](https://github.com/vlucas/phpdotenv) is used to load the `.env` file. All variables are then available in your app by `getenv`, `$_SERVER`, or `$_ENV`.

Currently, the following env vars are required:

* `DB_USER`
* `DB_NAME`
* `DB_PASSWORD`
* `WP_HOME`
* `WP_SITEURL`

### Composer

[Composer](http://getcomposer.org) is used to manage dependencies. Bedrock considers any 3rd party library as a dependency including WordPress itself and any plugins.


#### Plugins

[WordPress Packagist](http://wpackagist.org/) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](http://wordpress.org/plugins/) can easily be required.

To add a plugin, add it under the `require` directive or use `composer require <namespace>/<packagename>` from the command line. If it's from WordPress Packagist then the namespace is always `wpackagist-plugin`.

Example: `"wpackagist-plugin/akismet": "dev-trunk"`

Whenever you add a new plugin or update the WP version, run `composer update` to install your new packages.

`plugins`, and `mu-plugins` are Git ignored by default since Composer manages them. If you want to add something to those folders that *isn't* managed by Composer, you need to update `.gitignore` to whitelist them:

`!web/app/plugins/plugin-name`

Note: Some plugins may create files or folders outside of their given scope, or even make modifications to `wp-config.php` and other files in the `app` directory. These files should be added to your `.gitignore` file as they are managed by the plugins themselves, which are managed via Composer. Any modifications to `wp-config.php` that are needed should be moved into `config/application.php`. 

#### Updating WP and plugin versions

Updating your WordPress version (or any plugin) is just a matter of changing the version number in the `composer.json` file.

Then running `composer update` will pull down the new version.


### wp-cron

Bedrock disables the internal WP Cron via `define('DISABLE_WP_CRON', true);`. If you keep this setting, you'll need to manually set a cron job like the following in your crontab file:

`*/5 * * * * curl http://example.com/wp/wp-cron.php`


## Fork Info

This is based off of a modified version of [Bedrock](https://github.com/roots/bedrock)


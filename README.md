# Flickr Image Gallery Application

## Introduction

This application was built using Zend framework as a foundation to generate image galleries in response to user searches, drawing content from Flickr using their REST API.

## Installation using Composer

The easiest way to create a new Zend Framework project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

This application is set up to use Composer to resolve its dependencies. Run the following from within flickrimagegallery folder to install them:

```bash
$ composer self-update
$ composer install
```
Next, we need to create a database schema and tables using the data/schema.sql file in mysql. We need to set the db username and password into the config/autoload/local.php after renaming it from config/autoload/local.php.dist file as bellow. We also need to set flickr api key in this file.

```bash
return array(
     'db' => array(
         'username' => 'flickr_user',
         'password' => 'your_db_password',
     ),
     'flickr' => array(
         'api_key' => 'your_flickr_api_key',
      ),
 );
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/flickrimagegallery
$ php -S 0.0.0.0:8080 -t public/ public/index.php
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://0.0.0.0:8080
- which will bring up Zend Framework welcome page.

**Note:** The built-in CLI server is *for development only*.

## Development mode

The skeleton ships with [zf-development-mode](https://github.com/zfcampus/zf-development-mode)
by default, and provides three aliases for consuming the script it ships with:

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.

## Running Unit Tests

Todo: Done functinal test. Unit test couldn't be done due to time limit.


## Using Vagrant

This skeleton includes a `Vagrantfile` based on ubuntu 16.04 (bento box)
with configured Apache2 and PHP 7.0. Start it up using:

```bash
$ vagrant up
```

Once built, you can also run composer within the box. For example, the following
will install dependencies:

```bash
$ vagrant ssh -c 'composer install'
```

While this will update them:

```bash
$ vagrant ssh -c 'composer update'
```

While running, Vagrant maps your host port 8080 to port 80 on the virtual
machine; you can visit the site at http://localhost:8080/

> ### Vagrant and VirtualBox
>
> The vagrant image is based on ubuntu/xenial64. If you are using VirtualBox as
> a provider, you will need:
>
> - Vagrant 1.8.5 or later
> - VirtualBox 5.0.26 or later

For vagrant documentation, please refer to [vagrantup.com](https://www.vagrantup.com/)

## Using docker-compose

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName flickrimagegallery.localhost
    DocumentRoot /path/to/flickrimagegallery/public
    <Directory /path/to/flickrimagegallery/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

```nginx
http {
    # ...
    include sites-enabled/*.conf;
}
```


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/flickrimagegallery.localhost.conf`
it should look something like below:

```nginx
server {
    listen       80;
    server_name  flickrimagegallery.localhost;
    root         /path/to/flickrimagegallery/public;

    location / {
        index index.php;
        try_files $uri $uri/ @php;
    }

    location @php {
        # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_param  SCRIPT_FILENAME /path/to/flickrimagegallery/public/index.php;
        include fastcgi_params;
    }
}
```

Restart the nginx, now you should be ready to go!

### Storage selection:

Since user registration data needs to persist forever, I have chosen mysql as a storage.
The recent search results were also planning to save in the database flickr_images.flickr_image table but could not implement yet.

### Screens:

Some screenshots have been added under flickrimagegallery/screens directory for application preview.


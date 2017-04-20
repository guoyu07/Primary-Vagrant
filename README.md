Primary Vagrant
=============

_Note:_ Primary Vagrant 3.0 is a major upgrade from earlier versions. If you would like to use an older version please clone [the 2.x branch](https://github.com/ChrisWiegman/Primary-Vagrant/tree/2.x) instead.

Primary Vagrant is intended for WordPress plugin, theme, and core development, as well as general PHP development, and can be used as a replacement for local development stacks such as MAMP, XAMPP, and others.

Although [Varying Vagrant Vagrants](https://github.com/Varying-Vagrant-Vagrants/VVV) is great (and I still use it for some work), I wanted a few major changes. First, I wanted Apache instead of NGINX and, second, I wanted to use a more comprehensive provisioning tool like Puppet instead of Bash. Using VVV and Puppet as a base, this repository attempts to address these requirements for my own work with a Vagrant configuration that is ready to go for WordPress plugin or theme development.

The repository contains a Vagrant configuration with Puppet modules that will configure the following goodies:

* Ubuntu 16.04 LTS
* [Apache](http://httpd.apache.org)
* [PHP](http://php.net) 7.0
* [MySQL](https://www.mysql.com)
* [Xdebug](http://xdebug.org)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) *for PHP_CodeSniffer*
* [PHPUnit](https://phpunit.de)
* [Postfix](http://www.postfix.org)
* [wp-cli](http://wp-cli.org)
* [phpMyAdmin](http://www.phpmyadmin.net)
* [WordPress](https://wordpress.org) (Last, Stable, Trunk and Dev)
* Various debugging plugins for WordPress
* [Search Replace DB](http://interconnectit.com/products/search-and-replace-for-wordpress-databases/)
* [webgrind](https://github.com/jokkedk/webgrind/)
* [oh-my-zsh](http://ohmyz.sh)
* [MailHog](https://github.com/mailhog/MailHog)
* Test data from [WP Test](http://wptest.io)
* [Composer](https://getcomposer.org)
* [node.js](https://nodejs.org)
* [Git](http://git-scm.com)
* [Subversion](https://subversion.apache.org)
* [Memcached](https://memcached.org/)
* [Redis](http://redis.io/)

## Contributors

* [ChrisWiegman](https://github.com/ChrisWiegman)
* [kraftner](https://github.com/kraftner)
* [michaelbeil](https://github.com/michaelbeil)
* [NikV](https://github.com/NikV)

## Want to help?

If you find any issues, please don't hesitate to submit a [pull request](https://github.com/ChrisWiegman/Primary-Vagrant/blob/master/CONTRIBUTING.md).

## Getting Started

### Default domains

* pv - Default menu
* phpmyadmin.pv - phpMyAdmin
* replacedb.pv - Search Replace DB
* core.wordpress.pv - WordPress development (for core dev)
* legacy.wordpress.pv - Last version of WordPress (currently 4.6.x)
* stable.wordpress.pv - Latest WordPress stable (currently 4.7.x)
* trunk.wordpress.pv - WordPress trunk
* webgrind.pv - webgrind

### Install the software

Install [Vagrant](http://vagrantup.com), [VirtualBox](http://virtualbox.org), and the [VirtualBox extensions](https://www.virtualbox.org/wiki/Downloads) for your environment.

Once Vagrant is installed you'll want three plugins to update your local hosts and update the VirtualBox Guest additions in the Ubuntu install as well as for handling various tasks like backing up your databases when you're done for the day.

```vagrant plugin install vagrant-vbguest```

```vagrant plugin install vagrant-ghost```

or

```vagrant plugin install landrush```

```vagrant plugin install vagrant-triggers```

Installing landrush will allow you to use any domain name with the "pv" toplevel domain negating the need for extr setups, reloads, etc. With Landrush you can safely ignore anything below about pv-hosts and simply set any virtualhost to use a subdomain of pv.

### Launch your VM

1. Clone this repo (and it's submodules) onto your local machine:

    ```$ git clone --recursive https://github.com/ChrisWiegman/Primary-Vagrant.git PV```

    *Note: If you download it with the GitHub links you will not get the submodules and you'll wind up with a provisioning error.

1. Change into the new directory with `cd PV`

1. Start the Vagrant environment with `vagrant up`
	- Be patient as the magic happens. This could take a while on the first run as your local machine downloads the required files.
	- Pay attention during execution as an administrator or `su` ***password may be required*** to properly modify the hosts file on your local machine.

### Preconfigured Sites

The following websites come pre-configured in the system:

* [Default menu](http://pv)
* WordPress (last major release) at [http://legacy.wordpress.pv](http://legacy.wordpress.pv)
* WordPress (latest stable release) at [http://stable.wordpress.pv](http://stable.wordpress.pv)
* WordPress Trunk at [http://trunk.wordpress.pv](http://trunk.wordpress.pv)
* WordPress Core Development at [http://core.wordpress.pv](http://core.wordpress.pv)
* Search Replace DB [https://replacedb.pv](https://replacedb.pv)
* phpMyAdmin [http://phpmyadmin.pv](http://phpmyadmin.pv)
* WebGrind [http://webgrind.pv](http://webgrind.pv)
* MailHog [http://pv:8025](http://pv:8025)

*Note: WordPress Core dev is taken from git://develop.git.wordpress.org/. Only the src folder is mapped. You can manually set up a build site if desired.

### Configure Additional Sites

#### Using the Site Creator

##### Creating a Site

```php project.php --create-site```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash). For example:

Project name __My Project__

will be reachable at: http://my-project

##### Deleting a Site

```php project.php --delete-site```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash). For example:

Project name __My Project__

will delete the Primary Vagrant project files in the folder __my-project__

__**Note:** Deleting a project will NOT delete the database nor the files. You may delete the database manually if you desire and files in the sites folder can be deleted with the ```--deletefiles``` option.

##### Creating a Plugin

```php project.php --create-plugin```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash).

Plugins will be available on trunk.wordpress.pv, stable.wordpress.pv and legacy.wordpress.pv.

##### Deleting a Plugin

```php project.php --delete-plugin```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash).

##### Creating a Theme

```php project.php --create-theme```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash).

Themes will be available on trunk.wordpress.pv, stable.wordpress.pv and legacy.wordpress.pv.

##### Deleting a Theme

```php project.php --delete-theme```

You will be prompted for a project name. This will be the name of the folder in your Primary Vagrant Sites folder and will be mapped to a related domain whereas all non-domain characters, such as space, etc, will be replaces with a "-" (dash).

##### Advanced Usage

There are a number of advanced options you can use to customize your project there are as follows:

* ```norpovision``` Prevents vagrant from reloading and reprovisioning upon project creation/deletion.
* ```name``` Specify the project name without a prompt
* ```root``` A directory to map as the project root to keep the project files outside of Primary Vagrant. A folder with the project name will still be created in Primary Vagrant's sites folder but it will only hold files necessary for the project to be recognized in Primary Vagrant.
* ```deletefiles``` Use this to force file deletion upon project deletion. Without this only the Primary Vagrant files will be removed and the sites folder will remain. Does not apply to root folders outside of the Primary Vagrant structure.
* ```domain``` Specify the domain to use for a site. Will override the domain name generation from the project name.
* ```database``` by default sites will get a database of the same name as the domain name. Use this option to override the database name.
* ```alias``` Specify a domain alias for apache. Multiple aliases can be specified by calling this option multiple times.
* ```apacheroot``` Specify a subfolder of the project root to be used as the apache root folder. Useful for projects like the Laravel where you may want to map one folder but have Apache only serve part of it.
* ```nodatabase``` Don't create a database for a site project.


__Note: all options must be specified as --option=value (complete with the equal sign).

#### Manually Creating Sites

First, create a file called `pv-mappings` in the user-data directory. This will map any sites you create to the appropriate folder on PV.

Example Mapping:

```
config.vm.synced_folder "user-data/sites/my-site/htdocs", "/var/www/my-site.pv", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]
```

*Note that if you're working on a WordPress plugin or theme I would recommend to simply map it to the three pre-installed WordPress sites. This will make it easy for you to test it on multiple versions of WordPress.

Example:

```
config.vm.synced_folder "user-data/sites/my-awesome-plugin", "/var/www/default-sites/wordpress/content/plugins/my-awesome-plugin", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]
```

Next Edit **user-data/vhosts/``[your-site-domain].pp**. This is where you define virtualhosts and databases. Copy what is below and ask me if you have any questions. Of course these aren't the only configuration options you have either. You can find a [full list of Apache configuration options here](http://github.com/example42/puppet-apache) and a [full list of mysql configuration options here](https://github.com/puppetlabs/puppetlabs-mysql).

Example:

```
apache::vhost { 'mysite.pv':
    docroot                         => '/var/www/mysite.pv',
    directory                       => '/var/www/mysite.pv',
    directory_allow_override        => 'All',
    ssl                             => true,
    template                        => '/vagrant/provision/lib/conf/vhost.conf.erb'
}
```

``` mysql
mysql_database { 'mysite.pv':
    ensure  => 'present',
    charset => 'utf8',
    collate => 'utf8_general_ci',
    require => Class['mysql::server'],
}
```

*Note: I've provided a top-level wildcard SSL certificate. No further SSL certificate should be needed.

Finally, and you can do this two ways... 
* If you've created your site **inside** of the Primary Vagrant `user-data/sites/` folder, just add a file called `pv-hosts` to it that includes the domain name(s) (one per line) for your project. 
* If your site is **outside** of the Primary Vagrant folder I would recommend creating `user-data/pv-hosts` to hold the domain names. This will make sure you can access your sites by whatever domain names you need.

After the configuration above has been added, simply run `vagrant halt && vagrant up` to trigger the changes and host file updates.

### Changing configuration options

The default installation configuration is found in *provision/init/*. While you could edit these files if you like I would, instead, recommend adding any additional configuration to your virtualhosts file such as *user-data/vhosts/custom.pp*

#### Database Access

You can access the database via ssh tunnel into the machine using the *ouroboros* hostname, the username *vagrant*, the password *vagrant* for ssh, and the username *username* with the password *password* for MySQL.

#### Postfix Configuration

Postfix is configured and set to use your host computer as a mail relay. To receive messages you can use the built in [MailHog installation](http://pv:8025) (this will prevent your real SMTP mail server and mailbox from getting too much abuse).

#### node.js

The latest stable node.js version is installed, if you want to pre-install packages just add them to your sites virtualhost config such as *user-data/vhosts/nodejs.pp*.

Example:

``` javascript
package { 'ungit':
  provider => npm,
  require  => Class['nodejs']
}
```

### Debugging Code ###

Ouroboros comes pre-configured with two awesome tools for helping debug your code. The first is [Xdebug](http://xdebug.org/) and the second is [PHP_Codesniffer](https://github.com/squizlabs/PHP_CodeSniffer) (which comes complete with the [WordPress coding standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) already pre-configured). While configuration is dependant on the code editor you use here are some notes that might help you get started with them.

* Xdebug uses VAGRANT_DEBUG as its IDE key
* Many modern tools will let you access both of these tools easily with just a bit of configuration. For example, [here's a great post on using remote debugging in PHPStorm.](http://blog.jetbrains.com/phpstorm/2015/07/remote-tools-via-remote-php-interpreters-in-phpstorm-9/)
* [PHPStorm configuration suggestions are in the wiki](https://github.com/ChrisWiegman/Primary-Vagrant/wiki/XDEBUG-Setup-in-PHPStorm).

You can now also turn xdebug on or off completely with the commands `xon` and `xoff`. This should help speed up complex composer or other operations.

For debugging APIs or any other situation where sending a cookie with your request isn't ideal you can turn on auto-listening for xdebug in which case it will try to connect automatically, even without a cookie. To do this simply use the commands `xlon` and `xloff` to enable or disable auto-remote. Note that this is disabled by default.

### Contributions

Contributions are more than welcome. Please read our current [guidelines for contributing](CONTRIBUTING.md) to this repository. Many thanks in advance!

## Important

This server configuration is designed for development use only. Please don't put it on a production server as some of these settings would cause serious security issues.

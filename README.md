Primary Vagrant
=========

Primary Vagrant is intended for WordPress plugin, theme, and core development, as well as general PHP development in the UF Health environment and can be used as a replacement for local development stacks such as MAMP, XAMPP, and others.

*For more information and full documentation please visit* ***[this project's wiki](https://github.com/ChrisWiegman/Primary-Vagrant/wiki).***

Important
---------

This server configuration is designed for development use only. Please don't put it on a production server as some of these settings would cause serious security issues.

Quickstart
----------

1. Install [VirtualBox](http://virtualbox.org), and the [Oracle VM VirtualBox Extension Pack](https://www.virtualbox.org/wiki/Downloads) for your environment.

2. Install [Vagrant](http://vagrantup.com).

3. Once Vagrant is installed you can install the three optional plugins as discussed on the [Requirements](https://github.com/ChrisWiegman/Primary-Vagrant/wiki/Requirements) page.

    ```vagrant plugin install vagrant-vbguest```

    ```vagrant plugin install vagrant-triggers```

    ```vagrant plugin install landrush```

4. Clone Primary Vagrant (and it's submodules) onto your local machine:

    ```$ git clone --recursive git@github.com:ChrisWiegman/Primary-Vagrant.git Primary\ Vagrant```

5. Change into the new directory with `cd Primary\ Vagrant`

6. Start the Vagrant environment with `vagrant up`
	- Be patient as the magic happens. This could take a while on the first run as your host machine downloads the base box and Primary Vagrant downloads and installs all the software you'll need.
	- Pay attention during execution as an administrator or `su` ***password may be required*** to properly modify the hosts file on your local machine.

7. Navigate to [http://dashboard.pv](http://dashboard.pv) to get started.

Changelog
---------

#### 4.3.3 (04 August 17)
* Switch to https for WordPress.org plugin repositories

#### 4.3.2 (04 August 17)
* Update upstream Puppet modules
* Update WordPress Stable (4.8.1)

#### 4.3.1  (22 July 17)
* Upgrade default NodeJS version (8.2.1)
* Update upstream Puppet modules
* Update PhpMyAdmin (4.7.3)

#### 4.3 (5 July 17)
* Update upstream Puppet modules
* Update PhpMyAdmin
* Switch WordPress repos to git://core.git.wordpress.org/
* Added .sh extension to shell scripts where appropriate
* Renamed "init" folder to the more appropriate "manifests"

#### 4.2.2 (2 July 17)
* Update default NodeJS version (8.1.3)
* Update upstream Puppet modules

#### 4.2.1 (16 June 17)
* Update default NodeJS version (8.1.2)
* Update upstream Puppet modules

#### 4.2 (8 June 17)
* Define JETPACK_DEV_DEBUG for default sites to make it easier to keep plugins and themes under development compatible with Jetpack.
* Update WordPress versions to 4.8 for stable and 4.7.5 for legacy.
* Update PhpMyAdmin to 4.7.1

#### 4.1.3 (31 May 17)
* Updated default NodeJS version (8.0.0)
* Fixed URL for wp-cli download to avoid extra 301 redirects
* Update upstream Puppet modules

#### 4.1.2 (24 May 17)
* Fixed an update caused by a bad quote

#### 4.1.1 (24 May 17)
* Update upstream Puppet modules

#### 4.1 (22 May 17)
* Add WP Inspect plugin to aid in theme and plugin development
* Switch Debug Bar plugin to SVN repo to ensure timely updates
* Fixed bug in site generator due to obsolete file list (credit @Alex-Keyes)
* Fixed bug in Readme for proper link to Wiki (credit @chuckreynolds)

#### 4.0.4 (17 May 17)
* Update WordPress versions to 4.6.6 for Legacy and 4.7.5 for Stable

#### 4.0.3 (14 May 17)
* Update upstream Puppet modules

#### 4.0.2 (10 May 17)
* Downgrade PHPCS to 2.9 for compatibility with WordPress Coding Standards.
* Add Quickstart information
* Upgrade upstream Puppet modules

#### 4.0.1 (8 May 17)
* Fix PHPCS paths
* Fixed issue with mysql module (Credit @crazyjaco)
* Upgrade upstream Puppet modules

#### 4.0 (6 May 17)
* A complete overhaul with new features, better documentation and more. *This WILL require a destroy of an existing environment before upgrading*

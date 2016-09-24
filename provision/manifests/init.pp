import 'helpers/*.pp'

group { 'puppet': ensure => present }

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/', '/vagrant/provision/bin/' ] }
File { owner => 0, group => 0, mode => 0644 }

import 'components/system.pp'
import 'components/repos.pp'
import 'components/apache.pp'
import 'components/php.pp'
import 'components/mysql.pp'
import 'components/www.pp'
import 'components/wordpress.pp'

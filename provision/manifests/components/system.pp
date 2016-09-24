class { 'apt': }

package { 'git':
  ensure => 'installed'
}

package { 'vim':
  ensure => 'installed'
}

package { 'subversion':
  ensure => 'installed'
}

package { 'ntp':
  ensure => 'installed'
}

package { 'memcached':
  ensure => 'installed'
}

package { 'redis-server':
  ensure => 'installed'
}

class { 'ohmyzsh': }

ohmyzsh::install { 'ubuntu': }

class { 'nodejs':
  version      => 'latest',
  make_install => false,
}

file { '.zshrc':
  path    => '/home/ubuntu/.zshrc',
  ensure  => file,
  owner   => 'ubuntu',
  group   => 'ubuntu',
  source  => '/vagrant/provision/lib/conf/.zshrc',
}

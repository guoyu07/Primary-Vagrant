class { 'mysql::server':
  root_password           => 'password',
  remove_default_accounts => true,
}

mysql_database { 'stable.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8',
  collate => 'utf8_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'legacy.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8',
  collate => 'utf8_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'trunk.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8',
  collate => 'utf8_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'core.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8',
  collate => 'utf8_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'tests.core.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8',
  collate => 'utf8_general_ci',
  require => Class['mysql::server'],
}
# Class: demo
#
# This module downloads Maven Artifacts from Nexus
#
# Parameters:
# [*url*] : The Nexus base url (mandatory)
# [*username*] : The username used to connect to nexus
# [*password*] : The password used to connect to nexus
# [*netrc*] : Use .netrc to connect to nexus
#
# Actions:
# Checks and intialized the Nexus support.
#
# Sample Usage:
#  class nexus {
#   url => http://edge.spree.de/nexus,
#   username => user,
#   password => password
#}
#
class demo (
  $url='http://33.33.33.33:8081/nexus',
  $username = 'admin',
  $password = 'admin123',
  $netrc = undef,
) {

  # Check arguments
  $nexus_url = $url

  if((!$username and $password) or ($username and !$password)) {
    fail('Cannot initialize the Nexus class - both username and password must be set')
  }

  # Install script
  file { '/opt/nexus-script/download-artifact-from-nexus.sh':
    ensure  => file,
    owner   => 'root',
    mode    => '0755',
    source  => 'puppet:///modules/demo/download-artifact-from-nexus.sh',
    require => File['/opt/nexus-script']
  }

  file { '/opt/nexus-script': ensure => directory }

}

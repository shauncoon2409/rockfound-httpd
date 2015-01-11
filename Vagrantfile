# -*- mode: ruby -*-
# vi: set ft=ruby :

# ------------------------------------------------------------------------
# CONFIGURABLE PROPERTIES
# ------------------------------------------------------------------------

$project    = 'rockefeller'
$hostname   = $project + '.local'
$docroot 	= '/var/www/' + $project +'/html/'
$ip         = '192.168.33.11'

# ------------------------------------------------------------------------

$addVirualHost = <<SCRIPT
echo "Adding virual host"
VHOST=$(cat <<EOF
# Custom site file created upon vagrant provision.

# domain: #{$hostname}
# public: #{$docroot}

<VirtualHost *:80>

  # Admin email, Server Name (domain name) and any aliases
  ServerName #{$hostname}
  ServerAlias www.#{$hostname}

  # Index file and Document Root (where the public files are located)
  # DirectoryIndex index.html
  DocumentRoot #{$docroot}

  # Custom log file locations
  LogLevel warn
  # ErrorLog  /var/www/#{$project}/log/error.log
  # CustomLog /var/www/#{$project}/log/access.log combined

</VirtualHost>

EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/#{$hostname}.conf
sudo a2ensite #{$hostname}
sudo service apache2 restart
SCRIPT


$phpSettings = <<SCRIPT
#!/usr/bin/env bash

echo "Updating php.ini"
sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php5/apache2/php.ini

SCRIPT

# ------------------------------------------------------------------------

Vagrant.require_version '>= 1.5.1'

unless Vagrant.has_plugin?("vagrant-hostmanager")
  raise 'vagrant-hostmanager is missing, please install the plugin with `vagrant plugin install vagrant-hostmanager`'
end

unless Vagrant.has_plugin?("vagrant-vbguest")
  raise 'vagrant-vbguest is missing, please install the plugin with `vagrant plugin install vagrant-vbguest`'
end

Vagrant.configure('2') do |config|

  # Basics
  config.vm.box     = 'scotch/box'
  config.vm.hostname = $hostname
  config.vm.network :private_network, ip: $ip
  config.vm.synced_folder ".", "/var/www/" + $project + "/", :mount_options => ["dmode=777", "fmode=666"]


  # Set virtualbox memory
  config.vm.provider :virtualbox do |virtualbox|
    virtualbox.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
    virtualbox.customize ['modifyvm', :id, '--memory', "1024"]
    virtualbox.customize ['modifyvm', :id, '--cpus', "1"]
    virtualbox.customize ['modifyvm', :id, '--name', $hostname]
  end

  # Configure Hosts Manager
  if Vagrant.has_plugin?('vagrant-hostmanager')
    # Use hostonly network with a static IP Address and enable
    # hostmanager so we can have a custom domain for the server
    # by modifying the host machines hosts file
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.vm.define $project do |node|
      node.vm.hostname = $hostname
      node.vm.network :private_network, ip: $ip
      node.hostmanager.aliases = [ "www." + $hostname ]
    end
    config.vm.provision :hostmanager
  end

  # Provition (add vhost)
  config.vm.provision "shell", inline: $addVirualHost

end
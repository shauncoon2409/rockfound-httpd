# right now a single default.rb is taking care of it all

# set the correct time zone:
bash "set EST timezone" do
  user "root"
  code <<-EOH
      	echo "America/New_York" > /etc/timezone
	/usr/sbin/dpkg-reconfigure --frontend noninteractive tzdata
  EOH
  action :run
end


package "php5-mysql" do
    action :install
end


###directory "/var/www/rockefeller/rockfound-wp-code/html" do
###  recursive true
###  owner "nobody"
###  mode "755"
###  action :create
###end


web_app "rockefeller" do
    template 'vhost.conf.erb'
    server_name "staging.rock-public.ahundredyears.com"
    docroot "/var/www/rockefeller/html"
    allow_override 'All'
end


###template "/var/www/rockefeller/html/index.php" do
###  source "index.php.erb"
###  action :create # see actions section below
###end


git "/var/www" do
  repository "https://github.com/shauncoon2409/rockfound-httpd.git"
  revision "alpha201502032235"
  action :sync
end


link "/var/www/rockefeller" do
  to "/var/www/rockfound-wp-code/"
end



###template "/var/www/rockefeller/html/wp-config.php" do
###  source 'wp-config.php.erb'
###  owner "nobody"
###  mode "755"
###    variables({
###       :db_host_value => 'staging-opsworks-rocke-local.ctikyztoekms.us-east-1.rds.amazonaws.com',
###       :db_user_value => 'rockefeller',
###       :db_password_value => 'NoiseThankDesert',
###       :db_name_value => 'rocke_local',
###       :wp_home_value => "http://staging.rock-public.ahundredyears.com",
###       :wp_siteurl_value => "http://staging.rock-public.ahundredyears.com/wp"
###    })
###end  


##template "/var/www/rockefeller/config/application.php" do
##  source 'application.php.erb'
##  owner "nobody"
##  mode "755"
##    variables({
##    ###   :db_host => node[:db_host_value],
##       db_whatevs => #{node['fqdn']},
##       :db_user => node[:db_user_value],
##       :db_password => node[:db_password_value],
##       :db_name => node[:db_name_value],
##       :wp_home => node[:wp_home_value],
##       :wp_siteurl => node[:wp_siteurl_value]
##    })
##end  


#add composer
bash "download and install composer" do
  user "root"
  code <<-EOH
     /usr/bin/php -r "readfile('https://getcomposer.org/installer');" | php
  EOH
  action :run
end


# prepare composer to run
execute "composer-phar" do
  cwd '/var/www/rockefeller'
  command "php composer.phar install"
  action :run
end


# put the .env.erb file in place based on whatever variables we
# need, and then run composer:
template "/var/www/rockefeller/.env" do
  source '.env.erb'
  owner "nobody"
  mode "755"
#  notifies :run, "execute[composer-phar]", :immediately
end  


execute "apache2-restart" do
  command "/etc/init.d/apache2 stop"
  command "/etc/init.d/apache2 start"
  action :run
end






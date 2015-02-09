#directory(node)
#
#web_app(node) do
#  docroot(node)
#  template('vhost.conf.erb')
#end

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

package "php5-mysql" do
    action :install
end


###template "/var/www/rockefeller/html/index.php" do
###  source "index.php.erb"
###  action :create # see actions section below
###end


git "/var/www/rockefeller" do
  repository "https://github.com/shauncoon2409/rockfound-httpd.git"
  revision "alpha201502032235"
  action :sync
end


execute "apache2-restart" do
  command "/etc/init.d/apache2 stop"
  command "/etc/init.d/apache2 start"
  action :nothing
end


link "/var/www/rockefeller/html" do
  to "/var/www/rockefeller/rockfound-wp-code/html/"
end

link "/var/www/rockefeller/config" do
  to "/var/www/rockefeller/rockfound-wp-code/config/"
end

link "/var/www/rockefeller/html/wp" do
  to "/var/www/rockefeller/rockfound-wp-code/wp/"
end

link "/var/www/rockefeller/html/wp-admin" do
  to "/var/www/rockefeller/rockfound-wp-code/wp/wp-admin"
end


template "/var/www/rockefeller/html/wp-config.php" do
  source 'wp-config.php.erb'
  owner "nobody"
  mode "755"
    variables({
       :db_host_value => 'staging-opsworks-rf.ctikyztoekms.us-east-1.rds.amazonaws.com',
       :db_user_value => 'rockefeller',
       :db_password_value => 'Noise.Thank.Desert.4',
       :db_name_value => 'rocke_local',
       :wp_home_value => "http://www.rock-public.ahundredyears.com",
       :wp_siteurl_value => "http://www.rock-public.ahundredyears.com/wp"
    })
end  


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


template "/var/www/rockefeller/.env" do
  source '.env.erb'
  owner "nobody"
  mode "755"
  notifies :run, "execute[apache2-restart]", :immediately
end  




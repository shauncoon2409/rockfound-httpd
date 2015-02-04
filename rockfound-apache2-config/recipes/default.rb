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
#    cookbook 'apache2'
end


###template "/var/www/rockefeller/html/index.php" do
###  source "index.php.erb"
###  action :create # see actions section below
###end


git "/var/www/rockefeller" do
  repository "https://github.com/shauncoon2409/rockfound-httpd.git"
  revision "alpha201501291022"
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



template "/var/www/rockefeller/.env" do
  source '.env.erb'
  owner "nobody"
  mode "755"
  notifies :run, "execute[apache2-restart]", :immediately
  action: create
end  




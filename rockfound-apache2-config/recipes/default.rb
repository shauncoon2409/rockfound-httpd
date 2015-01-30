#directory(node)
#
#web_app(node) do
#  docroot(node)
#  template('vhost.conf.erb')
#end

directory "/var/www/rockefeller/html" do
  recursive true
  owner "nobody"
  mode "755"
  action :create
end


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


git "/var/www/rockefeller/htm" do
  repository "https://github.com/shauncoon2409/rockfound-httpd.git"
  revision "alpha201501291022"
  action :sync
end


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
    server_name node['staging.rock-public.ahundredyears.com']
    docroot "/var/www/rockefeller/html"
    allow_override 'All'
#    cookbook 'apache2'
end


template "/var/www/rockefeller/html/index.php" do
  source "index.php.erb"
  action :create_if_missing # see actions section below
end


#file '/var/www/html/index.php' do
#  content '<html>
# <head>
#  <title>PHP Test</title>
# </head>
# <body>
# <?php echo '<p>Hello World</p>'; ?> 
# </body>
#</html>'
#end
directory(node)

web_app(node) do
  docroot(node)
  template('vhost.conf.erb')
end

template "/var/www/html/index.php" do
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
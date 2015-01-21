directory(node)

web_app(node) do
  docroot(node)
  template('vhost.conf.erb')
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
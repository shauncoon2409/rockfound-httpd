directory(node)

web_app(node) do
  server_name(node)
  docroot(node)
  template('vhost.conf.erb')
end
Configurar apache
######################
Adicionar no seu conf do apache:

Alias /unipet-server "D:/unipet-pos/server/web"
<Directory "D:/unipet-pos/server/web">
  Options Indexes FollowSymLinks Includes ExecCGI
  AllowOverride None
  Require all granted
  Allow from all
</Directory>

Alias /unipet-client "D:/unipet-pos/client/web"
<Directory "D:/unipet-pos/client/web">
  Options Indexes FollowSymLinks Includes ExecCGI
  AllowOverride None
  Require all granted
  Allow from all
</Directory>
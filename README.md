# fumcpensacola.com

## Building locally

### Prerequisites
 * Apache with PHP
 * Node if you want to run the virtual host auto-setup
 * A `.htaccess` file defining environment variables:
  - `DB_HOST`
  - `DB_USER`
  - `DB_PASSWORD`
  - `DB_NAME`
  - `WP_ENV` ("production" or "development")
 
### Creating a virtual host
Run from the project root:

```bash
sudo node vhost.js
sudo apachectl restart
```

The site should now be available from [http://fumcpensacola.local](http://fumcpensacola.local).
## Codeline Wordpress Test

- Database dump is in root of project. <br>
- Database name is same as the name of sump file. <br>
- Configure database setting in wp-config.php. By default, username and passwd is "root" and "root".
- Administrator of blog is "admin" with passwd "admin"

#### To install in a local linux server:
- $ git clone https://github.com/andsalves-dev/gitesoft-wordpress-test.git
- $ cd gitesoft-wordpress-test/
- (Restore database with file in this root - wordpress_test.sql)
- Configure some virtualhost to this application (recommended) or set builtin php server
- Run application.
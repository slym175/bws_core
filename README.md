# Bws Core Packages 
This package for manager assets files
##Install
In your project base directory run
```bash
cd your-project-base-directory

composer require bws/core
```
- Install package:
```bash
php artisan bws/core:install

Would you like to publish the stubs now? (yes/no) [no]:
> yes

Would you like to publish the assets now? (yes/no) [no]:
> yes

Would you like to publish the migrations now? (yes/no) [no]:
> yes

Would you like to publish the plugin's assets now? (yes/no) [yes]:
> yes
```
- Create super admin user:
```bash
php artisan migrate

Change user model:
class User extends BwsCoreUser
{

}

php artisan bws/core:user
```
- Enjoy:

Go to http://127.0.0.1:8000/admin

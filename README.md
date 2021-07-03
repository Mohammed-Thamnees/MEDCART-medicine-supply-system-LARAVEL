

This project is completely developed in PHP Laravel framework. 


How to settup the project in your local system, follow the steps:-

	1) Clone the repo and cd into it
	2) Open terminal from the folder and type:
			composer install
	3) Rename or copy .env.example file to .env
	4) php artisan key:generate
	5) Set your database credentials in your .env file
	6) Run the command to get db
			php artisan migrate    //run the command
	7) Run command   :
		npm install
	8) and	
		npm run watch
	9) run command[laravel file manager]:
		php artisan storage:link
	10) Run command:
		php artisan serve 
			OR 
	    use virtual host
	11) Visit localhost:8000 in your browser
	12) For access to admin panel enter the admin username and password and for user enter user's too.
	
	
=======================================================================================================================
							*** NOTE ***
=======================================================================================================================

 If you get an error like below while running the command "php artisan storage link" please do as follow instruction.
 
 
------------------------------------------------------------------------------------------------------------------------ 
 			ERROR MESSAGE
 -----------------------------------------------------------------------------------------------------------------------
 
 ErrorException  : symlink(): No such file or directory

  at /var/www/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php:263
    259|      */
    260|     public function link($target, $link)
    261|     {
    262|         if (! windows_os()) {
  > 263|             return symlink($target, $link);
    264|         }
    265|
    266|         $mode = $this->isDirectory($target) ? 'J' : 'H';
    267|

  Exception trace:

  1   symlink()
      /var/www/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php:263

  2   Illuminate\Filesystem\Filesystem::link()
      /var/www/vendor/laravel/framework/src/Illuminate/Foundation/Console/StorageLinkCommand.php:35

  Please use the argument -v to see more details.
  
  
  
 ------------------------------------------------------------------------------------------------------------------------------
  				SOLLUTION
 ------------------------------------------------------------------------------------------------------------------------------
 
 

   1) Go to /public directory and run:

    		rm storage

   2) Go to Laravel root directory and run:

    		php artisan storage:link
    		
    		
===============================================================================================================================






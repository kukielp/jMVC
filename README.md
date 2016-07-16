# jMVC
A simple convention based PHP MVC framework

  - Routing engine
  - Filters
  - Pre and post controller execution ( handy for logging )
  - Clean URLs
  - Layout templating
  - Kint debug engine for simple debugging ( https://github.com/raveren/kint/ )
  - Convention based
  - Easy to use
  - Runs on PHP and HHVM

  Included .htaccess for apache re write and nginx rewite rule.

> **Note:**

> location / {
    if (!-e $request_filename){
      rewrite ^(.*)$ /index.php?$1;
    }

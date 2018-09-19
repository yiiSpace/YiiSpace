when install the phpdocumentor :

~~~
     
      - Installing phpdocumentor/phpdocumentor (dev-master 832aed4)
        Downloading: 100%
     
     
     
      [ErrorException]
      ZipArchive::extractTo(): Full extraction path exceed MAXPATHLEN (260)

~~~

solution:

>  https://github.com/composer/composer/issues/604

~~~
    
    In my case --prefer-source helped, (MAXPATHLEN (260) error)
    
    php composer.phar global require "phpdocumentor/phpdocumentor:2.*" --prefer-source

~~~


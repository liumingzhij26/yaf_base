#部署方式 

[nginx]
upstream touch_fastcgi {
    server 127.0.0.1:9000;
}

server {
 
    if (!-e $request_filename) {
        rewrite ^/(.*)  /index.php?/$1 last;
    }

   location ~ (\.php|\.inc)$ {
       try_files $uri /index.php =404;
       fastcgi_pass touch_fastcgi;
       fastcgi_index index.php;
       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       include fastcgi_params;
   }
}


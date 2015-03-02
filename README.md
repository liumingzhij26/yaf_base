#部署方式
[nginx]
server {
    include base_files.conf;
    listen       80;
    server_name	h5.lo.com;
    root	/home/www/web/public;

    gzip                    on;
    gzip_http_version       1.1;
    gzip_buffers            256 64k;
    gzip_comp_level         5;
    gzip_min_length         1000;
    gzip_proxied            expired no-cache no-store private auth;
    gzip_types              application/x-javascript ;

     access_log /home/logs/h5.lo.access.log;
     error_log  /home/jm/logs/h5.lo.error.log;

    gzip_disable "MSIE 6";

    if ( $request_method !~ GET|POST|HEAD ) {
        return 403;
    }

    proxy_buffers 64 4k;

    location / {
        index index.php;
        if (!-f $request_filename) {
            rewrite ^/(.*)$ /index.php/$1 last;
            break;
        }
    }

    location ~ (\.php|\.inc)$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

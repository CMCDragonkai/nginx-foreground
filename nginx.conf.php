daemon off;
master_process off;
worker_processes auto;
pid .nginx.pid;
error_log stderr info;
working_directory ./;

events { }

http {

    access_log /dev/stdout;

    client_body_temp_path /tmp/nginx/client 1 2;
    fastcgi_temp_path /tmp/nginx/fastcgi 1 2;

    root ./;

    include /etc/nginx/mime.types;
    include /etc/nginx/fastcgi.conf;

    default_type application/octet-stream;

    server {

        listen 127.0.0.1:80;
        listen [::1]:80;

        server_name localhost;

        index index.php index.html index.htm;

        location / {
            try_files $uri $uri/ /index.php;
        }

        location ~* \.php$ {

            try_files $uri =404;
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_intercept_errors on;
            fastcgi_hide_header x-powered-by;

        }

    }

}

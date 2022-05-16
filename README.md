#Логин:admin
#Пароль:1234567

user  nobody;
worker_processes  1;

error_log  logs/error.log;
error_log  logs/error.log  notice;
error_log  logs/error.log  info;

events {
    worker_connections  1024;
}


http {
    include       mime.types;
    default_type  application/octet-stream;

    server {

        listen 80;
        listen [::]:80;
        server_name test_task.com;
        root example-app/public;
        index index.php;


        auth_basic "Restricted";
        auth_basic_user_file .htpasswd; 
        #charset koi8-r;
        location / {
             try_files $uri $uri/ /index.php?$query_string;
        }

        error_page   404 /index.php;;
        location = /50x.html {
            root   html;
        }
    }

}

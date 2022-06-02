启动指令：
docker run --name=lexiangtu_pro --volume=/data/lexiangtu_pro:/var/www/lexiangtu --volume=/data/fansfood/media/lexiangtu:/var/www/lexiangtu/public/media/images/lexiangtu --workdir=/var/www -p 2000:80 --expose=9001 --restart=no --runtime=runc --detach=true -t webdevops/php-nginx


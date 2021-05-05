# Docker images

## Build

```sh
docker build -t myhobbies/apache .
```


## Run

```sh
docker run --name myhobbies-apache -d -p 80:80 -v $(pwd)/my-hobbies:/my-hobbies myhobbies/apache
```

## Debug

```sh
docker exec -it -u $(id -u):$(id -g) myhobbies-apache bash
```


## Useful resources

- https://laravel.com/docs/7.x#web-server-configuration
- https://blog.silarhi.fr/image-docker-php-apache-parfaite/

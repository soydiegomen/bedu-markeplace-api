# API Bedu Marketplace 

## Overview
API con Laravel, que permite hacer una prueba de concepto de un Marketplace para Bedu

## Información técnica

### Requisitos para su setup (local y producción)
* PHP += 7.3
* Composer
* Npm
* Mysql

### Notas generales
El proyecto esta basado en el boilerplate de Laravel. Se recomienda revisar la documentación de este proyecto, para conocer los detalles generales de su implementación e instalación. 
https://laravel-boilerplate.com/index.html 

### Guía de setup 

1. Clone el proyecto del repositorio de Github.
Para un ambiente de desarrollo utiliza la rama de development y la rama main para producción.
2. Instalar las librerías de php que requiere utilizando Composer
$ composer install

3. Instalar las dependencias de NPM
$ npm install

5. Configurar la conexión a la BD en el archivo .env
En el proyecto se encuentra un archivo de ejemplo .env.example renombrelo a .env y agregue la información de conexión a la BD

6. Genere las llaves que utiliza Laravel para encriptar  
$ php artisan key:generate

7. Ejecute las migraciones de la base de datos  
$ php artisan migrate

8. Poble la BD con la información base del proyecto  
$ php artisan db:seed  

9. Ejecute el comando run de npm  
Este comando compila archivos que necesita el proyecto para las interfaces.
$ npm run production

10.  Ejecute el comando de laravel para ligan el public storage para cargar los avatars de los usuarios  
$ php artisan storage:link

11. Ejecutar el script sql que se encuentra en el directorio:  
DATA/dump_base_project.sql

12. Levantar el servidor web 
$ php artisan serve


## Pruebas de la solución
Posterior a haber levantado el ambiente local

1. Abrir la aplicación de postman
Link de descarga https://www.postman.com/ 

2. En postman importar la colección de prueba
https://www.getpostman.com/collections/e7269855a265c250d699

3. Agregar un nuevo ambiente de postman, para resolver las variables de la url
host => 127.0.0.1:8000  
httP => http

2. Utilizar los request  
 
## Servicios del API

* **Products/Get products**  
Lista los productos registradas en el sistema  

* **Products/Create product**  
Crea un nuevo producto

* **Orders/Get orders**  
Lista las ordenes registradas en el sistema  

* **Orders/Create order**  
Crea una nueva orde (es posible enviar los productos que la integran)  

* **Orders/Add products**  
Agrega nuevos productos a la orden  

* **Orders/Pay order**  
Es un mock del servicio que registrará el pago de una orde, por ahora solo actualiza su estatus a pagada.  


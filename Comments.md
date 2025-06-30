# Proyecto de Citas Médicas
En este fihcero estarán los comentarios "extensos" del proyecto. En donde se explicarán partes del código com más detalle
## C00: Jetstream
*comentario no vinculado con ningun fichero*
Es un paquete de Laravel que proporciona un scaffolding (andamiaje) para aplicaciones web modernas. Es un paquete desarrollado por el equipo de Laravel y está diseñado para simplificar la configuración inicial de proyectos, especialmente aquellos que requiren autenticación y gestión de usuarios.
Además su instalación puede venir con Livewire(con Alpine) o con Inertia (con Vue/React)
- Livewire (con Alpine.js) → Enfoque más tradicional con PHP.
- Inertia.js con Vue/React → Para una experiencia más SPA (Single Page Application).

Para instalarlo:
```bash
composer create-project laravel/laravel example-app
cd example-app
composer require laravel/jetstream
```
En el caso del proyecto se estará utilizando Jetstream v5

Luego de su instalación será importante elegir si se trabajará con Livewire o con Inertia, en el caso del proyecto será con Livewire: `php artisan jetstream:install livewire`
## C01: Livewire
*comentario no vinculado con ningun fichero*
Livewire es un micro-framework **full-stack para Laravel**, permite crear interfaces dinámicas y reactivas **sin necesidad de escribir JavaScript puro** (aunque se puede combinar con Alpine.js para más interactividad). Permite trabajar con componentes dinámicos usando **PHP en el backend** y actualizaciones en tiempo real en el frontend **sin necesidad de una API REST**
- Desarrollar aplicaciones dinámicas como si fueran tradicionales (PHP + HTML) pero con reactividad similar a Vue/React.
- Evitar escribir JavaScript complejo para acciones comunes (ej: validaciones, filtros, modales, tabs, etc.).
- Integración directa con Laravel: Accede a modelos, validaciones, sesiones, etc., desde el componente PHP.
- Ideal para devs que prefieren PHP pero quieren una experiencia moderna (SPA-like).
## C02: MySQL
*comentario no vinculado con ningun fichero*
En el desarrollo del proyecto se está utilizando WSL 🐧, por lo que se deberá instalar MySQL para seguir con el proyecto.
```bash
sudo apt install mysql-server -y       # Instalar MySQL
sudo service mysql start               # Iniciar el servicio
```
Luego de su intalación faltaría ejecutar un "script de seguridad" (establece constraseña root y elimina configuraciones inseguras): `sudo mysql_secure_installation`

Luego del script de seguridad, falta acceser a MySQL: `sudo mysql -u root -p`

Ahora dentro de MySQL para la creación de la BD:
`CREATE DATABASE citas_medicas;`. Con esta línea estará creada la BD:
```bash
mysql> SHOW DATABASES;
+--------------------+
| Database           |
+--------------------+
| citas_medicas      |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)
```

Luego se deberá crear un usuario dedicado
`CREATE USER 'citas_user'@'localhost' IDENTIFIED BY 'unaContraseñaBuena';`

Luego faltaría asignarle los privelegios necesarios:
```bash
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP 
ON citas_medicas.* TO 'citas_user'@'localhost';
```
Este script hace que el usuario "citas_user" solo tenga acceso a la BD `citas_medicas`.

Se espera un resultado como este:
```bash 
mysql> CREATE USER 'citas_user'@'localhost' IDENTIFIED BY 'unaContraseñaBuena';
Query OK, 0 rows affected (0.02 sec)

mysql> GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP ON citas_medicas.* TO 'citas_user'@'localhost';
Query OK, 0 rows affected (0.01 sec)
```

Luego para finalizar faltaría hacer uso del usuario creado, esto se deberá especificar en el fichero `.env`
```bash
DB_DATABASE=citas_medicas
DB_USERNAME=citas_user
DB_PASSWORD=UnaContraseñaFuerte123!
```

Ahora para segurarse de que todo está bien, se correrán las migraciones:
```bash
php artisan migrate
INFO  Preparing database.

Creating migration table .. 44.03ms DONE

INFO  Running migrations.

  0001_01_01_000000_create_users_table . 191.27ms DONE
  0001_01_01_000001_create_cache_table .. 67.68ms DONE
  0001_01_01_000002_create_jobs_table .. 166.03ms DONE
  2025_06_30_155412_add_two_factor_columns_to_users_table .. 213.09ms DONE
  2025_06_30_155434_create_personal_access_tokens_table ... 85.11ms DONE
```

Una de las formas además de utilizar **Tinker** para la gestión de la BD, y es el caso que se utilzará en el desarrollo del proyecto es la extención de vscode [MySQL Database Client](https://database-client.com/)
##C
## C03:
##
##
##
##
##
##
##
##
##
##
##
##

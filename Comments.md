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
## C03: Laravel Lang (español)
Una caracteristica de Laravel pero opcional, es traducir la app, para eso está [Laravel Lang](https://laravel-lang.com/basic-usage.html).
**Laravel Lang** es una colección de paquetes de traducción que amplían el soporte de idiomas en Laravel.
Por defecto Laravel incluye algunso ficheros de idioma básicos en ingles(como validación, auth, paginación, etc) Laravel Lang es un proyecto de la comunidad que:
- Proporciona archivos de traducción completos en múltiples idiomas.
- Traduce automáticamente los mensajes comunes: validaciones, errores de autenticación, paginación, contraseñas, etc.
-  Facilita que una app sea multilingüe sin tener que traducir todo manualmente.
### Instalación
Para instalar Lang bastará con el comando `composer require laravel-lang/common` dentro del proyecto. Luego bastará con `php artisan lang:add es` para tener las traducciones en español.
Ahora dentro de `lang/es` estará la configuración general del idioma
### Uso de las traducciones
Ahora falta configurar Laravel para que utilice las traducciones descargadas.
Dentro del fichero `config/app.php` estará esto:
```bash
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
```
Aquí el idioma (`locale`) se establece que la sace de la variable de entorno (`.env`). entonces dentro de `.env` se deberá cambiar:
```bash
APP_LOCALE=es
```
Solo agregando "es" los cambios efectuarán en nuestra app.
## C04: Imagen de Usuario
Con Jetstream al darnos cosas ya creadas, podemos tuilizar imagenes de perfil para los usuarios del sistema. Primero en el fichero `config/jetstream.php` estará lo siguiente:
```bash
  'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
```
Como se puede apreciar hay varias opciones comentadas, las cuales no están por defecto, entonces hay que descomentar: `Features::profilePhotos(),`. Con ese cambio por defecto se actualizará nuestro usuario logeado en Jetstream y se mostrará una foto de perfil adaptado a su nombre de usuario, pero se pueden añadir imagenes personalizadas.
Para que se pueda subir una imagen a un perfil faltarían un par de cosas.
Si se está utilizando un Virtual Host en `.env` la variable `APP_URL` deberá estar con el URL de dicho virtual host.
Y dentro del mismo fichero, la variable `FILESYSTEM_DISK` debería estar en `public`
## C05: Zona Horaria
Para que los registros en la BD y otras configuraciones estén establecidas en el horario local, dentro del fichero `config/app.php`, en `timezone` se establecerá la zona horaria.
## C06: Ruta Admin
Para crear una ruta de forma separada se deberá crear el fichero `routes/admin.php`. Separar la rutas es útil para:
- Se mantienen las rutas ordenadas por responsabilidad (admin, frontend, API, etc.).
- En proyectos grandes, es más limpio que tener todo en web.php.
- Se puede aplicar middlewares específicos a cada grupo de rutas.

Entonces, siguiendo con `routes/admin.php`, dentro del fichero se deberán crear las rutas orientadas al "admin", y su utilidad es la misma que `routes/web.php`, solo que está en otro fichero para mantener un mejor orden.
Tambien dentro de `bootstrap/app.php` se deberá añadir por ejemplo:
```php
 then: function (){
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        }
```
Estás líneas le indican a Laravel que después de configurar las rutas principales (web.php, api.php, etc), también debe cargar el archivo `routes/admin.php`, y que todas las rutas dentro de ese archivo usen el middleware `web`.

De esta forma se podrá acceder la nueva ruta admin así: `http://127.0.0.1:8000/admin`.

` ->name('admin.')`: 
El método `->name()` en Laravel se utiliza para **asignar un prefijo de nombre a un grupo de rutas**. En este caso, `'admin.'` se aplicará como prefijo a todas las rutas definidas dentro del archivo `routes/admin.php`.

Esto permite que las rutas puedan ser referenciadas por un nombre completo en el código, facilitando su uso en redirecciones o generación de URLs.
Por ejemplo, si dentro del grupo defines una ruta con `->name('dashboard')`, su nombre completo será `admin.dashboard`, y podrás acceder a ella mediante `route('admin.dashboard'`.
## C07: Qué es un middleware?
Un middleware es una **capa intermedia** que se ejecuta antes o después de una solicitud HTTP. Sirve para filtrar, modificar o validar una petición.
Algunso Middleware del Laravel:
| Middleware       | ¿Qué hace?                                                          |
| ---------------- | ------------------------------------------------------------------- |
| `web`            | Habilita sesiones, cookies, protección CSRF, etc. (para rutas web). |
| `auth`           | Solo permite acceso si el usuario está autenticado.                 |
| `verified`       | Solo permite acceso si el email del usuario está verificado.        |
| `throttle`       | Limita la cantidad de peticiones por tiempo.                        |
| `admin` (custom) | Puedes crear uno para permitir solo a administradores.              |
## C08: Redirección a Raíz
Cuando se inicia sesión de Jetstream con email y contraseña, por defecto Jetstream redirecciona al Dashboard de Jetstream, es decir, luego de un logeo manda directo a `http://127.0.0.1:8000/dashboard`. Para cambiar esto se deberá hacer en `config/fortify.php`
>El archivo config/fortify.php pertenece a Laravel Fortify, que es el backend de autenticación utilizado por Laravel Breeze, Jetstream y otros stacks de Laravel. Entonces este fortify es el paquete que se encarga del proceso de autenticación.
Dentro de `config/fortify.php` en la parte:
```bash
'home' => '/dashboard',
```
Cambiarémos "dashboard" solo por la raíz: `'home' => '/',`

Con esto luego cuando se está en `http://127.0.0.1:8000/login` y se completan las credenciales ya no redireccionará al dashboard de Jetstream, sino que lo hará en la raíz: `http://127.0.0.1:8000/`.
## C09: Componente con clase
Siguiendo con los pasos del desarrollo, ahora toca la creación de un Componente con Clase, para eso en la terminal se deberá ejecutar:
```bash 
php artisan make:component AdminLayout
INFO  Component [app/View/Components/AdminLayout.php] created successfully.
INFO  View [resources/views/components/admin-layout.blade.php] created successfully. 
```
Pero antes de seguir es importante saber lo siguiente:
### 1. Componente de Línea 
Un **componente de línea** es aquel que se define directamente en un solo archivo Blade, sin lógica PHP adicional en una clase. Ejemplo
```bash
php artisan make:component Button --inline
```
Esta comando creará:
```bash
resources/views/components/button.blade.php
```
y el fichero podría tener solo esto:
```php
<button {{ $attributes->merge(['class' => 'bg-blue-500 text-white px-4 py-2 rounded']) }}>
    {{ $slot }}
</button>
```
Entonces un componente inline se basa en:
- Solo tiene una vista Blade (.blade.php).
- No hay una clase PHP asociada.
- Útil para componentes simples y reutilizables de interfaz (botones, etiquetas, badges).
### 2. Componente de Clase
Un componente de clase tiene 2 partes:
- Una clase PHP, que maneja la lógica
- Una vista Blase, que muestra contenido.
Un ejemplo sería:
```bash
php artisan make:component Alert
```
Y este comando crearía 2 ficheros:
```bash
app/View/Components/Alert.php          ← la lógica
resources/views/components/alert.blade.php  ← la vista
```

Y el contenido de `Alert.php` cómo se dijo, mantiene la lógica, ejemplo:
```php
class Alert extends Component
{
    public $type;

    public function __construct($type = 'info')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert');
    }
}
```
Y `alert.blade.php` sería la vista que está conectada a la lógica el fichero previo:
```php
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```

Entonces, cuándo utilizar uno u otro:
| Necesidad                      | Tipo recomendado    |
| ------------------------------ | ------------------- |
| Solo HTML reusable             | Componente de línea |
| Necesitas pasar datos / lógica | Componente de clase |
## C10: Estrucura de las view/routes/controller/layouts/etc
Sin seguir con ejemplos simulados, sino con ejemplos reales ahora toca definir la estrucura de las views de admin. En el comentario **C09** se menciona que se creó 2 ficheros con `make:component`, esos ficheros son
- `View/Components/AdminLayout.php`
- `views/components/admin-layout.blade.php`
Ahora como se está buscando crear un `layout` el fichero `components/admin-layout.blade.php` no será un componente común, será un `layout`, por lo que se moverá y renombrará a `resources/views/layouts/admin.blade.php`, ya que su funcion será un `layout` tiene más sentido que esté dentro de dicha carpeta y que solo se llame `admin.blade.php`, evitando redundancia.

Dentro de `resources/views/layouts/admin.blade.php` estará la estructura principal de las vistas de **admin**, y con la estrucura de componente se reutilizará el código repetitivo. 

Para mantener un mayor orden aun, se creó 2 ficheros:
- `resources/views/layouts/includes/app/navigation.blade.php`
- `resources/views/layouts/includes/app/sidebar.blade.php`
Ambos ficheros separados para un mejor orden del código, estos ficheros ahora deberán estar incluidos dentro de `layouts/admin.blade.php`, para eso en Laravel están las [Blade Templates](https://documentacionlaravel.com/docs/11.x/blade). Como ya se mencionó **Blade** es el motor de plantillas que se incluye con Laravel. 

En este punto, dentro del fichero `resources/views/layouts/admin.blade.php`, se hace uso de la directiva `@include` de Blade **para incluir otras plantillas parciales** que contienen secciones reutilizables del layout, en este caso:
```php
@include('layouts.includes.app.navigation')
@include('layouts.includes.app.sidebar')
``` 
Estas instrucciones indican que, al renderizar la vista, Laravel insertará el contenido de los archivos `navigation.blade.php` y `sidebar.blade.php` dentro del Layout principal. Esto permite **mantener el código limpio y organizado**, separando las distintas partesl del diseño en archivos individuales.
Por ejemplo, si en el futuro se desea modificar la barra lateral, solo se debe editar el archivo `sidebar.blade.php` sin necesidad de tocar el layout completo. 
Además, el uso de `includes` facilita la reutilización del mismo layout para múltiples vistas de administración, centralizando los elementos comunes como encabezados, navegación y scripts globales.
## C11: Estrucura general del panel de adminstración
Se ha creado una estrucura **modular y limpia** para el panel de administración.
📁`resources/views/admin/dashboard.blade.php`:
Este fichero **usa el componente de layout** `<x-admin-layout>`, el cual está conectado internamente a:
📁`resources/views/layouts/admin.blade.php`:
Aquí es donde entra el contenido que está dentro de `<x-admin-layout>`, el contenido ahora se mostraría por el `{{ $slot }}`. Laravel, por detras transforma el componente `x-admin-layout` en una clase (`App\View\Components\AdminLayout`) que renderiza la vista `layouts.admin`, y ahí inyecta el contendido de `slot`
📄 `routes/admin.php`:
```php
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');
```
El archivo `routes/admin.php` define las rutas exclusivas del panel admin. Gracias a la configuración del `bootstrap/app.php`, no es necesario anteponer `/admin` ni `admin.` en cada ruta manualmente, ya que se definen de forma global con:
```php
->prefix('admin')
->name('admin.')
```
Esta ruta(`routes/admin.php`) define que cuando un usuario accede a `/admin`, Laravel responderá con la vista `admin.dashboard`, es decir
- Usa `<x-admin-layout>` como estrucura
- Y el contenido se inyecta dentro del `{{ $slot }}` del layout `layouts.admin`.
## C12: Flowbite
Para **reducir el tiempo de desarrollo**, se optó por la utilización de [Flowbite](https://flowbite.com/), la cual porpociona una gran librería de componentes en Tailwind. 
Si por ejemplo en el pantel y vista `resources/views/layouts/includes/app/sidebar.blade.php` posee un `nav-bar` interactivo y responsivo en la página de **Flowbite** y no funciona las animaciones en el proyecto, es porque falta integrar Flowbite especialmente a [Laravel](https://flowbite.com/docs/getting-started/laravel/) *<-- Documentación de Flowbite sobre la integración con Laravel*

Dentro de la documentación, en la sección [Install Flowbite](https://flowbite.com/docs/getting-started/laravel/#install-flowbite). Indica se deberá instalar la dependencia de Flowbite usando NPM en el proyecto.
`npm install flowbite --save`

Luego de la instalación ir al fichero main de css `resources/css/app.css` e importar lo siguiente:
```css
@import "flowbite/src/themes/default";
@plugin "flowbite/plugin";
@source "../../node_modules/flowbite";
```
Luego de la importación se deberá correr en la terminal `npm run build`, para que se incorporen los cambios realizados

Finalmente, faltaría agregar el script de Flowbite en la plantilla de admin en este caso:
` <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>`, quedaría:
```php
 @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
```
Con eso ya funcionaría los los efectos de las plantillas de Flowbite
## C13: Componentes ya creados
Jetstream viene con distintos componentes ya creados, los cuales se le puede dar un uso propio (por ejemplo los ficheros `resources/views/components/button.blade.php`, `resources/views/components/dropdown.blade.php`, `resources/views/components/nav-link.blade.php`, etc) **son componentes Blade predefinidos por Jetstream**

Laravel Jetstream incluye una colección de componentes Blade reutilizables ubicados usualmente en `resources/views/components/`.
Estos componentes forman parte de la interfaz visual del sistema de autenticación y funcionalidades incluidas en Jetstream, como:
- Formularios (login, registro, actualización de perfil, etc.)
- Modalidades (confirmación, eliminación, etc.)
- Navegación y menús (dropdown, nav-link)
- Feedback visual (action-message, input-error, etc.)

Jetstream también utiliza **Livewire**(en este caso) y  y estos componentes ayudan a componer interfaces dinámicas rápidamente, manteniendo el código limpio y desacoplado.
## C14: Reutilización de la plantilla admin para el perfil de usuario de Jetstream
Por defecto, en el archivo `resources/views/profile/show.blade.php`, se utiliza el componente `<x-app-layout>`, que corresponde al layout base proporcionado por Jetstream. Este layout incluye la estructura general del frontend para las páginas del usuario autenticado.

Sin embargo, se puede integrar el perfil de usuario dentro de tu panel de administración personalizado, reemplazando `<x-app-layout>` por `<x-admin-layout>`.

Esto hará que la plantilla `admin` se cargue, incluyendo elementos como el **sidebar** y la **navbar** que se definió en layouts.admin. El contenido del perfil de usuario se mostrará dentro del `{{ $slot }}` del layout, permitiendo así reutilizar toda la estructura de administración sin perder la funcionalidad del panel de perfil.
## C15: Composición dinámica de vistas mediante datos estructurados
Dentro del fichero `resources/views/layouts/includes/app/sidebar.blade.php`, se hace una reutilización de código con un array de configuración, esto se llama: **composición dinámica de vistas mediante datos estructurados**, es una práctica común y recomendada.
Para seguir el ejmplo del fichero lo que pasa es lo siguiente:

**1. Definición de array `$links`**
Este array tiene toda la infromación que necesita el sidebar:
 - Enlaces normales(`name`, `icon`, `href`, `active`)
- Encabezados de sección (`header`)
- Submenús(`submenu` con más enlaces dentro)
Esto permite cambiar el contenido del sidebar sin tocar HTML directamente. Solo se editará el array.

**2. Uso de un `@foreach`**
Recorrer ese array y se decide qué tipo de ítem se motrará:
- Si tiene `header` -> muestra un título
- Si tiene `submenu` -> se genera un dropdown
- Si no tiene niguno de esos -> es un enlace normal
```php
@isset($link['header'])   // título
@isset($link['submenu'])  // dropdown
else                      // link simple
```

**3. Resuable, limpio y desacoplado**
- Se puede añadir, quitar o cambiar secciones sin duplicar HTML
- Separa los **datos de la vista**, lo cual es muy mantenible
- Se puede mover este `$links` a un fichero PHP o incluso a BD si se quiere escalar

Entonces si hace un Renderizado condicional basado en configuración, se hace una Generación dinámica de interfaces y se tiene un Menú dinámico con estructura de datos. en otras palabras, se usa un array como fuente de vedad para generar dinámicacmente el contenido HTML del menú.
## C16: @Props
`@props()` sirve para definir **valores que recibirá un componente Blade**. Son como los "atributos" que se puede pasarle al componente, y se comportan como variables internas.
Relacionado a los ficheros vinculados a `@props` está el componente `admin.blade.php`:
```php
@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => [],
])
```
Aquí lo que pasa es lo siguiente:
- Se puede pasar un `title`, y si no se hace, será el nombre de la app por defecto(el nombre de la app por defecto está en `.env`: `APP_NAME="Citas Médicas"`)
- Se puede pasar un array llamado `breadcrumbs`, que si no se hace será un array vacío.

Otro fichero vinculado es `dashboard.blade.php`:
```php
<x-admin-layout
    title="Dashboard | Citas médicas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Prueba',
        ],
    ]"
>
    HOLA DESDE EL ADMIN
</x-admin-layout>
```
**Estos envía esos valores como props al layout:**
- `"Dashboard | Citas médicas"` llega a la variable `$title`.
- El array de rutas llega a `$breadcrumbs`
## C17: Migas de pan (breadcrumb)
En el fichero `admin.blade.php`, está incluyendo la vista:
```php
@include('layouts.includes.admin.breadcrumb')
```
Como ya se definió `$breadcrumbs` con `@rops`, **esa variable estará disponible dentro del include.**
Y en el fichero `breadcrumb.blade.php` está lo siguiente:
```php
@if (count($breadcrumbs)) // Solo si hay elementos

    <ol>
        @foreach ($breadcrumbs as $item)
            <li>
                @isset($item['href'])
                    <a href="{{ $item['href'] }}">{{ $item['name'] }}</a>
                @else
                    {{ $item['name'] }}
                @endisset
            </li>
        @endforeach
    </ol>

    @if (count($breadcrumbs) > 1)
        <h6>{{ end($breadcrumbs)['name'] }}</h6>
    @endif

@endif
```
Esto musetra el listado de rutas, como:
```bash
Dashboard / Prueba
```
Y luego el título principal es el último elemento ('prueba')
## C18:
## C19:
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
##

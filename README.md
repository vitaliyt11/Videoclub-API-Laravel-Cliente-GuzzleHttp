# Proyecto - Videoclub (Cliente/Servidor)

Este repositorio contiene una aplicación dividida en dos partes:
1. **Server (API):** Desarrollado en Laravel, proporciona los servicios y endpoints (API RESTful) para la gestión del catálogo de películas y sus géneros correspondientes.
2. **Client:** Aplicación web en PHP que consume la API del servidor haciendo uso de la librería `GuzzleHttp`.

---

## 📋 Requisitos Previos

Para poder ejecutar este proyecto en tu máquina local, necesitarás tener instalado:

* **XAMPP:** Con los servicios de Apache y MySQL/MariaDB activados. (Se requiere PHP 8.1 o superior).
* **Composer:** El gestor de dependencias de PHP.

---

## 🚀 Instalación y Configuración en XAMPP

Clona o mueve la carpeta raíz del proyecto (la que contiene `client` y `server`) dentro de la carpeta pública de XAMPP, típicamente ubicada en: `C:\xampp\htdocs\`.

### 1. Configuración del Servidor (API en Laravel)

1. Abre tu terminal o línea de comandos y navega hasta el directorio del servidor:
   ```bash
   cd C:\xampp\htdocs\VideoclubPHP\server
   ```

2. Instala las dependencias de Laravel mediante Composer:
   ```bash
   composer install
   ```

3. Configura el archivo de entorno:
   Copia el archivo `.env.example` y renómbralo a `.env`. Puedes hacerlo desde el explorador de archivos o con el comando:
   ```bash
   copy .env.example .env
   ```

4. Configura la Base de Datos:
   Abre XAMPP, inicia el servicio **MySQL** y entra en phpMyAdmin (`http://localhost/phpmyadmin`). Crea una base de datos nueva (por ejemplo, `dwes06`). Luego, edita tu nuevo archivo `.env` en la carpeta `server` y actualiza las credenciales:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dwes06
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Ejecuta las migraciones y puebla la base de datos (Seeders):
   Este comando creará las tablas necesarias y utilizará `VTVSeeder` para insertar usuarios, géneros y películas iniciales.
   ```bash
   php artisan migrate --seed
   ```

### 2. Configuración del Cliente

1. En tu terminal, navega ahora a la carpeta del cliente:
   ```bash
   cd C:\xampp\htdocs\VideoclubPHP\client
   ```

2. Instala las dependencias del cliente (GuzzleHttp):
   ```bash
   composer install
   ```

---

## 💻 Uso del Proyecto

### Ejecución de la API
Para servir la API del lado de Laravel tienes dos opciones:
* **Opción A (Recomendada):** Usa el servidor de desarrollo de Artisan corriendo en la terminal dentro de `/server`:
  ```bash
  php artisan serve
  ```
  Esto expondrá la API en `http://localhost:8000/api/`.
* **Opción B:** A través de Apache de XAMPP directamente, accediendo a la ruta de la carpeta public: `http://localhost/VideoclubPHP/server/public/api/`.

### Ejecución del Cliente
1. Asegúrate de que el cliente tiene configurada correctamente la URI base (Base URI) en la instanciación de su cliente Guzzle (`GClientVTV`) apuntando a la URL elegida para tu API en el paso anterior.
2. Abre tu navegador web y dirígete al index del cliente (dependiendo del archivo principal que utilices, por ejemplo):
   `http://localhost/VideoclubPHP/client/`

Una vez allí, el cliente podrá comunicarse con la API para listar géneros, así como listar, crear, modificar el argumento o borrar películas VTV.

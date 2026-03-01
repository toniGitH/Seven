<p align="center">
  <img src="public/img/dice.png" alt="Seven Dice Game" width="250">
</p>

# Seven - Juego de Dados API

Este proyecto es una API REST desarrollada con **Laravel 12**, creada como parte del **Sprint 5** del bootcamp de **FullStack PHP** en **IT Academy (Barcelona Activa)**.

## 🎲 Explicación del proyecto

**Seven** es un simulador de un juego de dados que incluye gestión de partidas y estadísticas.

El núcleo de la lógica se basa en el **número 7**: cuando un jugador realiza un lanzamiento, el sistema genera dos números aleatorios (1-6). Si la suma es exactamente 7, el movimiento se registra como un éxito; de lo contrario, es un fallo.

### 🎭 Funcionalidades clave por rol:

##### 👤 Jugadores (Players)

- **Historial Persistente:** cada lanzamiento queda registrado en la base de datos, almacenando el valor de cada dado y el resultado (ganado/perdido).
- **Gestión de Carrera:** los jugadores pueden consultar todo su historial de partidas para analizar sus rachas o, si prefieren empezar de cero, tienen la posibilidad de **eliminar todo su historial** de lanzamientos.
- **Métricas de Rendimiento:** la API calcula en tiempo real el porcentaje de éxito individual del jugador basándose en su historial.

##### 👑 Administradores (Admins)

- **Control Total:** acceso a la lista completa de usuarios registrados en el sistema, incluyendo sus porcentajes de éxito actualizados.
- **Análisis Competitivo (Ranking):** el sistema genera un ranking global que ordena a todos los jugadores por su eficacia.
- **Hall of Fame & Shame:** consultas rápidas para identificar instantáneamente quién es el **mejor jugador** (el ganador con mayor porcentaje) y quién es el **peor jugador** (el que tiene el porcentaje más bajo) de toda la plataforma.

### 🛡️ Arquitectura de Seguridad

El proyecto implementa un sistema de **RBAC (Role-Based Access Control)**. 

Utiliza **Laravel Passport** para la emisión de tokens JWT seguros tras el login, y los permisos están blindados mediante middleware, asegurando que un jugador solo pueda ver sus propios datos y que las funciones estadísticas globales queden reservadas exclusivamente para los administradores.

## 🛠️ Tecnologías Utilizadas

- **Lenguaje:** PHP 8.3
- **Framework:** [Laravel 12](https://laravel.com/)
- **Autenticación:** [Laravel Passport](https://laravel.com/docs/11.x/passport) (OAuth2)
- **Autorización:** [Spatie Laravel-Permission](https://spatie.be/docs/laravel-permission/v6/introduction) (Roles y Permisos)
- **Base de Datos:** SQLite (por defecto para desarrollo/tests)
- **Testing:** PHPUnit

## 🚀 Paso a paso para probarlo

Sigue estos pasos para configurar y ejecutar el proyecto localmente desde un clon del repositorio:

### 1. Requisitos previos
Asegúrate de tener instalados:
- PHP >= 8.2
- Composer
- SQLite (o tu motor de base de datos preferido)

### 2. Clonación e Instalación
Clonar el repositorio:
```bash
git clone <url-del-repositorio>
cd Seven_private
```

Instalar dependencias de PHP:
```bash
composer install
```

### 3. Configuración del entorno
Crear el archivo .env:
```bash
cp .env.example .env
```

Generar la clave de la aplicación:
```bash
php artisan key:generate
```


### 4. Migraciones y Seeders
Este paso es crucial, ya que los seeders crearán los roles necesarios (`admin` y `player`) y varios usuarios de prueba (como `admin@email.com` con password `12345678`).

Ejecutar migraciones y poblar la base de datos (si no existe el archivo de base de datos, el sistema pedirá autorización para crearlo):
```bash
php artisan migrate --seed
```

### 5. Configuración de Passport
Genera las claves y el cliente necesarios para la autenticación JWT:
```bash
php artisan passport:keys
php artisan passport:client --personal --name="Personal Access Client" --no-interaction
```

### 6. Ejecución del servidor
```bash
php artisan serve
```
La API estará disponible en `http://localhost:8000`.

## 📂 Credenciales de prueba (Seeders)
Puedes usar estas cuentas para probar los diferentes roles:
- **Admin:** `admin@email.com` / `12345678`
- **Jugador:** `mortadelo@email.com` / `12345678`

## 📂 Endpoints Principales

### Acceso Público
- `POST /api/players`: Registro de un nuevo jugador.
- `POST /api/login`: Inicio de sesión (devuelve un token personal).

### Usuarios Autenticados (con Token)
- `POST /api/logout`: Cierre de sesión y revocación del token.
- `PUT /api/players/{id}`: Modificar el nombre del jugador.

### Solo Jugadores (`role:player`)
- `POST /api/players/{id}/games`: Realizar un lanzamiento de dados.
- `GET /api/players/{id}/games`: Listar todos los lanzamientos del jugador.
- `DELETE /api/players/{id}/games`: Eliminar el historial de lanzamientos.
- `GET /api/players/{id}/average`: Ver porcentaje medio de éxitos.

### Solo Administradores (`role:admin`)
- `GET /api/players`: Listado de todos los jugadores con su porcentaje medio de éxitos.
- `GET /api/players/ranking`: Ranking general de jugadores.
- `GET /api/players/ranking/winner`: Datos del jugador con mejor ranking.
- `GET /api/players/ranking/loser`: Datos del jugador con peor ranking.

## 🧪 Testing
Para ejecutar la suite de pruebas y verificar que todo funciona correctamente:
```bash
php artisan test
```

## 📮 Guía para probar la API Seven con Postman

👉 [Cómo probar la API Seven con Postman](POSTMAN.md)

# 📮 Cómo probar la API Seven con Postman

Esta guía detalla cómo configurar y realizar peticiones a la API **Seven** utilizando Postman.

↩️ [Volver al README](README.md)

## 1. Configuración Inicial

### URL Base
Asegúrate de que tu servidor local esté corriendo (`php artisan serve`). La URL base por defecto es:
`http://localhost:8000/api`

### Headers Globales
Para todas las peticiones, añade los siguientes encabezados en Postman:
- `Accept`: `application/json`
- `Content-Type`: `application/json`

---

## 2. Autenticación (Passport)

La API utiliza **OAuth2 Personal Access Tokens**. Para acceder a las rutas protegidas, primero debes obtener un token.

### Obtener Token (Login)
1. Crea una petición **POST** a `http://localhost:8000/api/login`.
2. En la pestaña **Body**, selecciona `raw` y `JSON`.
3. Introduce las credenciales (puedes usar las de los seeders):
    ```json
    {
        "email": "admin@email.com",
        "password": "12345678"
    }
    ```
4. Envía la petición y copia el valor del campo `token` de la respuesta.

### Usar el Token en rutas protegidas
En cualquier petición privada:
1. Ve a la pestaña **Authorization**.
2. Selecciona **Type**: `Bearer Token`.
3. Pega el token en el campo **Token**.

---

## 3. Guía de Endpoints

### 👤 Registro y Login (Público)
- **POST** `/players`: Crea un nuevo usuario.
    - Body JSON: `{"name": "TuNombre", "email": "test@email.com", "password": "password"}` (el nombre es opcional, por defecto es 'anonimo').
- **POST** `/login`: Login de usuario. Devuelve el token necesario para el resto de rutas.

### 🎲 Jugador (Role: `player`)
*Requiere Auth (Bearer Token) de un usuario con rol 'player'.*

- **POST** `/players/{id}/games`: Realiza un lanzamiento.
- **GET** `/players/{id}/games`: Lista todos tus lanzamientos y muestra tu porcentaje de éxito actual.
- **DELETE** `/players/{id}/games`: Borra todo tu historial de lanzamientos.
- **GET** `/players/{id}/average`: Muestra solo tu porcentaje medio de éxito.
- **PUT** `/players/{id}`: Cambia tu nombre de usuario.

### 👑 Administrador (Role: `admin`)
*Requiere Auth (Bearer Token) de un usuario con rol 'admin'.*

- **GET** `/players`: Lista de todos los jugadores registrados y sus porcentajes de éxito.
- **GET** `/players/ranking`: Ranking de todos los jugadores ordenados por éxito.
- **GET** `/players/ranking/winner`: Muestra al jugador (o jugadores) con mejor ranking.
- **GET** `/players/ranking/loser`: Muestra al jugador (o jugadores) con peor ranking.

---

## 💡 Tips de Postman

1. **Variables de Entorno**: Te recomendamos crear un "Environment" en Postman con una variable `base_url` seteada a `http://localhost:8000/api`. Así tus rutas se verán como `{{base_url}}/login`.
2. **Authorization Inheritance**: Puedes configurar el Bearer Token a nivel de **Colección** en Postman. Así, todas las peticiones dentro de la carpeta heredarán automáticamente el token sin tener que pegarlo en cada una.

↩️ [Volver al README](README.md)
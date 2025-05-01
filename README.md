# Este proyecto es de código visible, pero no libre. No está permitido su uso, redistribución ni modificación sin autorización

# API My Mood (Estado de ánimo diario)

Una API REST construida en PHP que permite registrarel estado de ánimo diario del usuario, devuelve frase motivacional de acuerdo al estado de ánimo y proporciona un resumen semanal. Utiliza **Composer** para autoloading y **JWT(JSON Web Tokens)** para la autenticación.

## Tabla de Contenidos

- [Características](#características)
- [Instalación](#instalación)
- [Uso](#uso)
- [Autenticación](#autenticación)
- [Endpoints](#endpoints)
- [Requisitos](#requisitos)

## Características

- Registrar estados de ánimo diarios
- Obtener frase motivacional
- Consultar el resumen del estado de ánimo semanal
- Autenticación con JWT
- Organización con Composer y PSR-4 autoloading

## Requisitos

- PHP 8.0 o superior
- Composer
- Servidor web (Apache)
- Base de datos MySQL

## Instalación

1. clona el repositorio:
   git clone https://github.com/ortiz-dev/apimymood.git
   cd apimymood
2. Instala las dependencias con Composer:
   composer install
3. Configura el archivo "config.php" con tus credenciales de base de datos y clave JWT
4. Ejecuta el servidor local(Xampp):
   ir al navegador y ingresar la url: http://localhost/apimymood/v1/register

## Autenticación

Esta API utiliza JWT. Primero debes autenticarte y recibir un token para acceder a los endpoints protegidos

POST apimymood/v1/login
Content-Type: application/json

{
"username": "usuario@correo.com",
"password": "tu_contraseña"
}

## Endpoints

- POST apimymood/v1/register - Crear cuenta de usuario
- POST apimymood/v1/login - Obtener token JWT
- POST apimymood/v1/moods - Registrar estado de ánimo
- GET apimymood/v1/phrases/today - Obtener la frase motivacional según el estado de ánimo de hoy
- GET apimymood/v1/moods/summary - Obtener resumen de la semana

## Uso

Ejemplo de petición para registrar un estado de ánimo:
POST apimymood/v1/moods
Authorization: Bearer TU_TOKEN_JWT
Content-Type: application/json
{
"state": "Hoy me siento algo contento y feliz"
}

# Sistema de Gestión de Minimarket 

## Requisitos Previos
- Docker y Docker Compose instalados.
- PHP 8.x instalado en el sistema host.

## Instrucciones de Ejecución

1. **Levantar la base de datos MySQL:**
   En la raíz del proyecto, ejecuta:
   `docker-compose up -d`
   *(Espera unos 15 segundos a que MySQL inicialice la base de datos y cree la tabla mediante init.sql).*

2. **Iniciar el Microservicio Backend (API REST):**
   Abre una nueva terminal, navega a la carpeta `backend` y ejecuta el servidor integrado de PHP en el puerto 8000:
   `cd backend`
   `php -S localhost:8000`

3. **Iniciar el Microservicio Frontend:**
   Abre otra terminal, navega a la carpeta `frontend` y ejecuta el servidor en el puerto 8080:
   `cd frontend`
   `php -S localhost:8080`

4. **Acceder al sistema:**
   Abre un navegador web y ve a `http://localhost:8080`.

## Arquitectura
- **MySQL (Docker):** Puerto 3306. Guarda los datos con persistencia.
- **Backend (PHP):** Puerto 8000. Expone endpoints GET, POST, PUT, DELETE.
- **Frontend (PHP):** Puerto 8080. Consume la API usando cURL y file_get_contents. No tiene conexión directa a la BD.
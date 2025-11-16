# Storage compartido para imágenes (Ubuntu)

Este proyecto puede almacenar imágenes en un "storage" centralizado configurable por variables de entorno.

## 1) Crear `.env`
Copia el archivo `.env.example` como `.env` en la raíz del proyecto y ajusta:

```
PANDORA_STORAGE_PATH=/var/www/ProyectoPandora/Public/img
PANDORA_STORAGE_URL=http://10.199.45.247/img
```

## 2) Crear carpetas y permisos
En el servidor Ubuntu:

```bash
sudo mkdir -p /var/www/ProyectoPandora/Public/img/{device,profile,inventory,ticket}
sudo chown -R www-data:www-data /var/www/ProyectoPandora/Public/img
sudo chmod -R 775 /var/www/ProyectoPandora/Public/img
```

## 3) Reiniciar Apache
```bash
sudo systemctl restart apache2
```

## 4) Probar
- Sube una imagen desde la app.
- La URL debe verse como `http://10.199.45.247/img/device/archivo.jpg`.
- Cualquier compañero debería verla igual.

## 5) Diagnóstico (solo admin)
Visita como Administrador:

```
index.php?route=Default/StorageDiag
```

Devolverá un JSON con `base_path`, `base_url` y otros datos útiles para verificar la configuración.

## 6) (Opcional) Redirigir IP raíz a la aplicación
Si al ingresar solo la IP (http://10.199.45.247/) quieres que cargue la app automáticamente y mantienes
el proyecto en `/var/www/html/ProyectoPandora`, crea un `index.php` en `/var/www/html` con:

```php
<?php
header('Location: index.php?route=Default/Index');
exit;
```

O ejecuta (como root) el script incluido:

```bash
sudo bash Scripts/setup_root_redirect.sh
```

Luego abre: `http://10.199.45.247/` y debe redirigirte a la home.

## Notas sobre imágenes legadas
Si en la BD quedaron rutas tipo `C:\...` (Windows), esas imágenes no existen en Ubuntu. Re-subirlas desde la app (ya con storage centralizado) o copiar los archivos al directorio `Public/img` y actualizar la columna en la BD al path relativo (por ejemplo, `device/mi_foto.jpg`).

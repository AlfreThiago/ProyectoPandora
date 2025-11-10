# Storage compartido para imágenes (Ubuntu)

Este proyecto puede almacenar imágenes en un "storage" centralizado configurable por variables de entorno.

## 1) Crear `.env`
Copia el archivo `.env.example` como `.env` en la raíz del proyecto y ajusta:

```
PANDORA_STORAGE_PATH=/var/www/html/ProyectoPandora/Public/uploads
PANDORA_STORAGE_URL=http://10.199.45.247/ProyectoPandora/Public/uploads
```

## 2) Crear carpetas y permisos
En el servidor Ubuntu:

```bash
sudo mkdir -p /var/www/html/ProyectoPandora/Public/uploads/{device,profile,inventory,ticket}
sudo chown -R www-data:www-data /var/www/html/ProyectoPandora/Public/uploads
sudo chmod -R 775 /var/www/html/ProyectoPandora/Public/uploads
```

## 3) Reiniciar Apache
```bash
sudo systemctl restart apache2
```

## 4) Probar
- Sube una imagen desde la app.
- La URL debe verse como `http://10.199.45.247/ProyectoPandora/Public/uploads/device/archivo.jpg`.
- Cualquier compañero debería verla igual.

## 5) Diagnóstico (solo admin)
Visita como Administrador:

```
/ProyectoPandora/Public/index.php?route=Default/StorageDiag
```

Devolverá un JSON con `base_path`, `base_url` y otros datos útiles para verificar la configuración.

## Notas sobre imágenes legadas
Si en la BD quedaron rutas tipo `C:\...` (Windows), esas imágenes no existen en Ubuntu. Re-subirlas desde la app (ya con storage centralizado) o copiar los archivos al directorio de `uploads` y actualizar la columna en la BD al path relativo (por ejemplo, `device/mi_foto.jpg`).

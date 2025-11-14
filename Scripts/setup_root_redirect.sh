#!/usr/bin/env bash
# Crea un index.php en /var/www/html que redirige a la app Pandora
# Uso: sudo bash setup_root_redirect.sh

set -euo pipefail

TARGET_DIR="/var/www/html"
INDEX_FILE="$TARGET_DIR/index.php"

cat <<'PHP' | sudo tee "$INDEX_FILE" > /dev/null
<?php
header('Location: index.php?route=Default/Index');
exit;
PHP

sudo chown www-data:www-data "$INDEX_FILE"
sudo chmod 644 "$INDEX_FILE"

echo "Listo: $INDEX_FILE creado."
echo "Abrí http://<IP-del-servidor>/ para verificar la redirección."

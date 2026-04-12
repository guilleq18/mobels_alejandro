#!/bin/bash
# Script de instalación automática para MOBELS ALEJANDRO en Hostinger
# Uso: bash ~/setup-mobels.sh

echo "🚀 INSTALANDO MOBELS ALEJANDRO EN HOSTINGER"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# PASO 1: Verificar que estamos en el lugar correcto
echo -e "${YELLOW}1️⃣  Verificando ubicación...${NC}"
pwd
echo ""

# PASO 2: Ir a public_html
echo -e "${YELLOW}2️⃣  Navegando a public_html...${NC}"
cd ~/public_html || exit 1
echo "   ✓ En: ~/public_html"
echo ""

# PASO 3: Eliminar carpeta vieja si existe
if [ -d "laravel_app" ]; then
    echo -e "${YELLOW}3️⃣  Eliminando carpeta laravel_app antigua...${NC}"
    rm -rf laravel_app
    echo "   ✓ Eliminada"
else
    echo -e "${YELLOW}3️⃣  No hay carpeta anterior${NC}"
fi
echo ""

# PASO 4: Clonar repositorio
echo -e "${YELLOW}4️⃣  Clonando repositorio desde GitHub...${NC}"
git clone https://github.com/guilleq18/mobels_alejandro.git laravel_app
if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Error clonando repositorio${NC}"
    exit 1
fi
echo "   ✓ Clonado correctamente"
echo ""

# PASO 5: Navegar al proyecto
echo -e "${YELLOW}5️⃣  Navegando al proyecto...${NC}"
cd laravel_app || exit 1
echo "   ✓ En: ~/public_html/laravel_app"
echo ""

# PASO 6: Instalar dependencias
echo -e "${YELLOW}6️⃣  Instalando dependencias PHP (puede tardar 10 minutos)...${NC}"
composer install --no-dev --optimize-autoloader
if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Error instalando composer${NC}"
    exit 1
fi
echo "   ✓ Dependencias instaladas"
echo ""

# PASO 7: Configurar Git
echo -e "${YELLOW}7️⃣  Configurando Git...${NC}"
git config user.email "alejandro.willi@gmail.com"
git config user.name "Alejandro"
echo "   ✓ Git configurado"
echo ""

# PASO 8: Crear .env
echo -e "${YELLOW}8️⃣  Creando archivo .env...${NC}"
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "   ✓ .env creado"
else
    echo "   ⚠️  .env ya existe"
fi
echo ""

# PASO 9: Mostrar instrucciones para editar .env
echo -e "${YELLOW}9️⃣  Editar .env${NC}"
echo "   Ejecuta: nano .env"
echo "   Ajusta estas líneas:"
echo "   • DB_DATABASE=u519347385_mobels"
echo "   • DB_USERNAME=u519347385_mbaguero"
echo "   • DB_PASSWORD=Alejandro123!"
echo "   • APP_URL=https://mobelsalejandro.shop"
echo ""
echo -e "${YELLOW}   ⏸️  PAUSA MANUAL - Edita .env ahora:${NC}"
echo "   nano .env"
echo ""
echo "   Luego vuelve aquí y presiona ENTER para continuar..."
read -p "   Presiona ENTER cuando hayas guardado .env..."
echo ""

# PASO 10: Ejecutar migraciones
echo -e "${YELLOW}🔟 Ejecutando migraciones...${NC}"
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Error en migraciones${NC}"
    echo "   Verifica que la BD existe y credentials son correctos"
    exit 1
fi
echo "   ✓ Migraciones completadas"
echo ""

# PASO 11: Crear usuario admin
echo -e "${YELLOW}1️⃣1️⃣  Creando usuario admin...${NC}"
php artisan db:seed
if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Error en seeder${NC}"
    exit 1
fi
echo "   ✓ Usuario admin creado"
echo ""

# PASO 12: Verificación final
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}✅ INSTALACIÓN COMPLETADA${NC}"
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo "📍 Ubicación: ~/public_html/laravel_app"
echo ""
echo "🌐 Accede a:"
echo "   • Sitio: https://mobelsalejandro.shop"
echo "   • Admin: https://mobelsalejandro.shop/admin/login"
echo ""
echo "👤 Credenciales:"
echo "   • Email: alejandro@example.com"
echo "   • Password: password"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

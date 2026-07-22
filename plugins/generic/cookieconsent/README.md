# CookieConsent plugin para OJS 3.5

Instalación rápida:
1. Copia la carpeta `cookieconsent` dentro de `plugins/generic/` en tu instalación de OJS.
2. Desde el panel de administración de OJS: Administración -> Plugins -> Generic -> busca "Banner de cookies" y haz clic en "Enable".
3. Para configurar el texto/URL, en la lista de plugins, con el plugin habilitado usa el botón "Ajustes" (abre un modal), modifica y guarda.

Notas:
- Usa la librería cookieconsent v3 desde CDN (jsdelivr). Si prefieres hospedar los assets localmente, dime y preparo la versión con los archivos incluidos.
- Actualmente guarda ajustes a nivel sitio (contextId = 0). Si quieres configuración por revista/contexto ajusto el código para usar el contexto actual.
- Este plugin muestra el banner y guarda la elección en una cookie por la propia librería cookieconsent; no bloquea automáticamente scripts por categorías. Si necesitas bloqueo granular (analytics/marketing), puedo añadir:
  - detección y bloqueo de scripts (envolviendo los scripts en data-attributes y activándolos tras consentimiento)
  - o integración con un servicio especializado (Cookiebot, etc.).

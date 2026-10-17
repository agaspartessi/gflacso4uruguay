# Uruguay para Moodle 5.3

17 de octubre de 2026. Rama `moodle-5.3`. Release `2.0.0-beta4`.

Parte de `8ac9aef24d591129e3af0f720f569c94091c2dab` de Uruguay y adapta
las correcciones de Académico hasta `354b41070bad5ffc31f0a624a87a8676af84025f`.
Esta actualización se aplica únicamente a la rama de Uruguay, sin fusionar `main`.

## Cambios

- La navegación principal y el menú del curso recuperan texto más grande y
  pestañas rectangulares. La selección principal muestra el triángulo verde y
  el menú del curso conserva la pestaña azul; el hover distingue cada opción.
  Se mantienen el foco de teclado y los menús desplegables de Moodle 5.3.
- En cursos Tiles, el contenido y el encabezado vuelven al ancho limitado de
  Boost que utilizan las anclas de los cajones. Esto permite abrir cualquiera
  de los dos cajones, o ambos, y expandir mosaicos sin tapar el contenido ni
  desplazar un cajón fuera de pantalla. La regla sólo se aplica a la página
  de curso Tiles; se conservan su paleta, tarjetas y demás estilos.
- Los cajones heredan de Boost su altura dinámica, cabeceras, scroll,
  apertura/cierre, foco, preferencias y comportamiento móvil. Se retiran las
  posiciones absolutas, desplazamientos negativos, alturas y z-index antiguos.
- Los botones de apertura quedan en los bordes de la pantalla; los de cierre
  permanecen dentro de cada cabecera. Se conserva el foco nativo de Boost.
- Navbar y contenido usan las variables compartidas `$navbar-height: 62px` y
  `$course-content-maxwidth: 1000px`. Se retiran anchos y márgenes que interferían
  con los cálculos de los cajones. Los informes conservan el layout ancho de Boost.
- El footer institucional ocupa el ancho disponible, sin franjas laterales ni
  separación artificial respecto del contenido. Se conserva el mosaico y los
  datos propios de Uruguay. El footer fijo vuelve a usar la geometría de Boost.
- Navbar adaptada a `.bg-body`, navegación MDS, texto del usuario, iconos y
  selector de edición sobre fondo azul. Los desplegables conservan texto oscuro.
- Login adaptado mediante `templates/core/login_layout.mustache`: mantiene el
  mosaico y el panel azul centrado de Uruguay. El contenido de Moodle permanece
  dinámico. Alturas mínimas permiten formularios largos; se ajusta el contraste
  de títulos, etiquetas, subtítulos y botones de acceso externo de Moodle 5.3.
- Se preservan la paleta azul/verde, tipografías, imágenes, iconos, settings,
  footer y reglas de cursos/contenidos. No se copia el theme completo de Académico.

## Carga de SCSS

Moodle ejecuta callbacks de Boost y del hijo. El orden ahora es:

1. Boost: color de marca y Raw initial SCSS del theme hijo.
2. Uruguay: `pre.scss`, con variables `!default`.
3. Preset seleccionado seguido de `post.scss` de Uruguay.
4. Boost: Raw SCSS final y reglas de fondos.

Los ajustes Raw se incorporan una sola vez y conservan su prioridad. Se mantienen
los presets default, plain, subidos y fallback. Plain añade `design-system`, que
su preset de Boost 5.3 omite aunque el SCSS de Moodle requiere esos tokens.
Los presets personalizados subidos deben ser compatibles con 5.3; no se modifican
automáticamente. `$CFG->dirroot` ya apunta a `public` en Moodle 5.3.

## Validación

Referencia: Moodle `MOODLE_503_STABLE`, commit
`344c92d5bb70f37306829d7739e2710305a39c3e`.

Los verificadores usan PHP 8.3, el compilador y callbacks reales de Moodle, y
Chromium con los templates/controlador de cajones de Boost y el formulario de
login de core. Almacenamiento de presets, preferencias y servicios externos
se simulan. No se carga la configuración ni la base de datos de un campus.

- Compilación de default, plain, preset subido, fallback y marca/Raw SCSS.
  Verifica también que Raw SCSS no se duplique y respete el orden.
- Cajones: 96 combinaciones de viewport, layout y estado; apertura/cierre,
  scroll interno, retorno del foco, ajuste móvil, footer y contraste del header.
- Tiles: 128 combinaciones de viewport, cajones, vista de curso/sección y
  mosaico expandido, con la hoja de estilos del plugin cargada después del theme.
- Navegación Moodle 5.3: cuatro anchos de escritorio con selección, hover,
  tipografía, menú Más y ausencia de desborde horizontal.
- Login: cinco tamaños de pantalla, contraste, acceso externo y formulario largo.
- Sintaxis PHP/JavaScript y `git diff --check`.

Comandos para reproducir desde el checkout del theme:

```bash
php tools/check_compatibility.php /ruta/al/moodle /tmp/uruguay-css
npm install --no-save playwright mustache
npx playwright install chromium
node tools/check_drawers.cjs /ruta/al/moodle /tmp/uruguay-css/moodle-default.css /tmp/uruguay-drawers
node tools/check_tiles_drawers.cjs /tmp/uruguay-drawers /ruta/a/format/tiles/styles.css
node tools/check_navigation.cjs /tmp/uruguay-drawers
node tools/check_login.cjs /ruta/al/moodle /tmp/uruguay-css/moodle-default.css /tmp/uruguay-login
```

El nombre del CSS incluye el nombre de la carpeta de Moodle: sustituir
`moodle-default.css` si corresponde. `CHROMIUM_EXECUTABLE_PATH` permite usar
un Chromium ya instalado. Las pruebas bloquean peticiones HTTP externas;
no verifican fuentes ni recursos remotos del campus.

## Instalar en testing

1. Descargar la rama `moodle-5.3` actualizada. La carpeta debe llamarse
   `gflacso4uruguay`, sin el sufijo de la rama.
2. Sustituir el theme en `<moodle>/public/theme/gflacso4uruguay` en testing.
3. Entrar en Administración del sitio > Notificaciones y registrar `2026101701`.
4. Purgar todas las cachés y recargar el navegador con `Ctrl+F5`.
5. Revisar Raw initial SCSS y Raw SCSS del campus: reglas antiguas de cajones,
   navbar o `.main-inner` podrían reintroducir desajustes por su prioridad final.
6. Probar login, recuperación y autenticación externa/MFA si se usan; Tablero,
   Mis cursos y cursos representativos con los cajones cerrados/abiertos, edición
   de bloques, menús, calificaciones y actividades, en escritorio y celular.
7. En un curso Tiles real, abrir y cerrar el índice y los bloques, solos y
   juntos; pulsar Expandir y volver, en pantalla ancha, tablet y celular.
   Comprobar también otro formato de curso y los roles estudiante y docente.

Estas pruebas aisladas no sustituyen la validación en el campus. La versión
sigue BETA hasta esa revisión. El modo oscuro experimental no está validado
para la identidad de Uruguay. Las URLs y reglas particulares existentes se
conservan y deben comprobarse en testing.

## Referencias oficiales

- [Moodle 5.3](https://moodledev.io/general/releases/5.3)
- [Notas de Boost](https://github.com/moodle/moodle/blob/MOODLE_503_STABLE/public/theme/boost/UPGRADING.md)
- [SCSS de cajones](https://github.com/moodle/moodle/blob/MOODLE_503_STABLE/public/theme/boost/scss/moodle/drawer.scss)
- [Callbacks de themes](https://github.com/moodle/moodle/blob/MOODLE_503_STABLE/public/lib/classes/output/theme_config.php)

# Sistema de Notas Dinámico

## Descripción

Sistema de gestión de notas que permite a los profesores cargar y editar notas por períodos de manera dinámica.

## Funcionalidades Implementadas

### 1. Estructura de Carpetas

-   `resources/views/profesores/notas/` - Vistas principales
    -   `index.blade.php` - Lista de materias con botón único
    -   `cargar.blade.php` - Tabla dinámica para cargar notas
    -   `totales.blade.php` - Vista de estadísticas

### 2. Controlador

-   `app/Http/Controllers/Profesores/NotaController.php`
    -   **index()** - Lista materias del profesor
    -   **cargar()** - Carga alumnos con notas existentes
    -   **guardarNotas()** - Guarda/actualiza notas en base de datos
    -   **totales()** - Muestra estadísticas

### 3. Modelo

-   `app/Models/InformePeriodo.php`
    -   Tabla: `informe_periodo`
    -   Campos: `id_asignacionesalumnos`, `cupof`, `dni_personal`, `fecha`, `nota`, `periodo`
    -   Relaciones con CUPOF y profesores

### 4. Base de Datos

Utiliza la tabla `informe_periodo` existente con:

-   **periodo**: 1, 2, 3 (representa los períodos del año)
-   **nota**: decimal(2) para calificaciones
-   **cupof**: relación con materia/curso
-   **id_asignacionesalumnos**: relación con estudiante

### 5. Características de la Interfaz

-   **Vista simplificada**: Solo un botón "Gestionar Notas" por materia
-   **Tabla dinámica**: Carga automáticamente alumnos y notas existentes
-   **3 períodos**: Simplificado a períodos 1, 2 y 3
-   **Guardado AJAX**: Sin recarga de página
-   **Limpieza individual**: Botón para limpiar notas por alumno

### 6. Rutas

```php
// Grupo de rutas para profesores
Route::get('profesores/notas', [NotaController::class, 'index'])->name('profesores.notas.index');
Route::get('profesores/notas/cargar/{cupof}', [NotaController::class, 'cargar'])->name('profesores.notas.cargar');
Route::post('profesores/notas/guardar', [NotaController::class, 'guardarNotas'])->name('profesores.notas.guardar');
Route::get('profesores/notas/totales/{cupof}', [NotaController::class, 'totales'])->name('profesores.notas.totales');
```

## Flujo de Trabajo

1. **Profesor accede a sus materias** → `profesores.notas.index`
2. **Selecciona "Gestionar Notas"** → `profesores.notas.cargar/{cupof}`
3. **Sistema carga alumnos y notas existentes** dinámicamente
4. **Profesor edita notas** en la tabla
5. **Guarda cambios** → AJAX a `profesores.notas.guardar`
6. **Sistema actualiza/crea registros** en `informe_periodo`

## Ventajas del Sistema

✅ **Dinámico**: Carga notas existentes automáticamente
✅ **Simplificado**: Solo 3 períodos en lugar de múltiples evaluaciones
✅ **Eficiente**: Guardado AJAX sin recargas
✅ **Intuitivo**: Una sola tabla editable
✅ **Consistente**: Sigue el patrón de asistencias existente

## Próximos Pasos Posibles

-   Implementar vista de estadísticas (`totales.blade.php`)
-   Agregar validaciones de notas (rango 1-10)
-   Exportar notas a PDF/Excel
-   Historial de cambios de notas
-   Notificaciones a alumnos

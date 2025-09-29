<title>{{ $title ?? 'hola' }}</title>
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Favicon icon -->
<link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<!-- Required Framework -->
<link rel="stylesheet" href="{{ asset('libraries/bower_components/bootstrap/css/bootstrap.min.css') }}">
<!-- themify-icons line icon -->
<link rel="stylesheet" href="{{ asset('libraries/assets/icon/themify-icons/themify-icons.css') }}">
<!-- ico font -->
<link rel="stylesheet" href="{{ asset('libraries/assets/icon/icofont/css/icofont.css') }}">
<!-- feather Awesome -->
<link rel="stylesheet" href="{{ asset('libraries/assets/icon/feather/css/feather.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Style.css -->
<link rel="stylesheet" href="{{ asset('libraries/assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('libraries/assets/css/jquery.mCustomScrollbar.css') }}">

<script src="https://kit.fontawesome.com/aae8b7156c.js" crossorigin="anonymous"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">

<!-- Estilos personalizados para profesores -->
<style>
    /* ===== ASISTENCIAS STYLES ===== */
    .asistencias-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
    }

    .asistencias-header {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .asistencias-header {
            flex-direction: row;
            align-items: center;
            gap: 0;
        }
    }

    .header-content h1.main-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 640px) {
        .header-content h1.main-title {
            font-size: 1.5rem;
        }
    }

    .header-content p.main-subtitle {
        color: #6b7280;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    @media (min-width: 640px) {
        .header-content p.main-subtitle {
            font-size: 1rem;
        }
    }

    .header-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .header-info {
            flex-direction: row;
            align-items: center;
            gap: 1rem;
        }
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #6b7280;
    }

    @media (min-width: 640px) {
        .date-info {
            font-size: 0.875rem;
        }
    }

    /* Grid de materias */
    .materias-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .materias-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .materias-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* Cards de materias */
    .materia-card {
        background: linear-gradient(to bottom right, #f9fafb, #e0f2fe);
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease-in-out;
    }

    .materia-card:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .materia-content {
        padding: 1rem;
    }

    @media (min-width: 640px) {
        .materia-content {
            padding: 1.5rem;
        }
    }

    .materia-header {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .materia-header {
            flex-direction: row;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 0;
        }
    }

    .materia-info {
        flex: 1;
    }

    .materia-title {
        font-weight: 600;
        font-size: 1rem;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 640px) {
        .materia-title {
            font-size: 1.125rem;
        }
    }

    .materia-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        margin: 0;
    }

    @media (min-width: 640px) {
        .materia-subtitle {
            font-size: 0.875rem;
        }
    }

    .materia-details {
        margin-bottom: 0.75rem;
    }

    @media (min-width: 640px) {
        .materia-details {
            margin-bottom: 1rem;
        }
    }

    .detail-item {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 640px) {
        .detail-item {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
    }

    .detail-item i {
        width: 0.75rem;
        height: 0.75rem;
        margin-right: 0.5rem;
    }

    @media (min-width: 640px) {
        .detail-item i {
            width: 1rem;
            height: 1rem;
        }
    }

    /* Botones de acción */
    .materia-actions {
        padding-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .materia-actions {
            padding-top: 1rem;
        }
    }

    .btn-primary-custom {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border: 1px solid transparent;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 0.375rem;
        color: white;
        background-color: #2563eb;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    @media (min-width: 640px) {
        .btn-primary-custom {
            font-size: 0.875rem;
        }
    }

    .btn-primary-custom:hover {
        background-color: #1d4ed8;
        color: white;
        text-decoration: none;
    }

    .btn-primary-custom:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    .btn-primary-custom i {
        margin-right: 0.5rem;
    }

    .btn-secondary-custom {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 0.375rem;
        color: #374151;
        background-color: white;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    @media (min-width: 640px) {
        .btn-secondary-custom {
            font-size: 0.875rem;
        }
    }

    .btn-secondary-custom:hover {
        background-color: #f9fafb;
        color: #374151;
        text-decoration: none;
    }

    .btn-secondary-custom:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    .btn-secondary-custom i {
        margin-right: 0.5rem;
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .empty-icon {
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 4rem;
        width: 4rem;
        border-radius: 50%;
        background-color: #f3f4f6;
    }

    .empty-icon i {
        color: #9ca3af;
        font-size: 1.25rem;
    }

    .empty-title {
        margin-top: 1rem;
        font-size: 1.125rem;
        font-weight: 500;
        color: #111827;
    }

    .empty-subtitle {
        margin-top: 0.5rem;
        color: #6b7280;
    }

    /* ===== TOMAR ASISTENCIAS STYLES ===== */
    /* Estilos para tabla de asistencias */
    .asistencia-radio-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .asistencia-radio-group .form-check {
        margin-right: 0;
        padding-left: 0;
    }

    .asistencia-radio-group .form-check-input {
        margin-top: 0;
        margin-right: 0.25rem;
    }

    .asistencia-radio-group .form-check-label {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        cursor: pointer;
        margin-bottom: 0;
    }

    .asistencia-radio-group .form-check-label i {
        font-size: 0.875rem;
    }

    /* Centrar checkbox de justificado */
    .justificado-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .justificado-center .form-check {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 0;
    }

    .justificado-center .form-check-input {
        margin-top: 0;
        margin-right: 0.5rem;
        position: relative;
    }

    .justificado-center .form-check-label {
        margin-bottom: 0;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    /* Mejorar visualización del checkbox deshabilitado */
    .justificado-center .form-check-input:disabled {
        opacity: 0.6;
        cursor: not-allowed !important;
    }

    .justificado-center .form-check-input:disabled+.form-check-label {
        opacity: 0.6;
        cursor: not-allowed !important;
        color: #6c757d !important;
    }

    /* Estados de habilitado/deshabilitado más claros */
    .justificado-center .form-check-input:not(:disabled) {
        opacity: 1;
        cursor: pointer;
    }

    .justificado-center .form-check-input:not(:disabled)+.form-check-label {
        opacity: 1;
        cursor: pointer;
        color: #495057;
    }

    .asistencia-mobile-container {
        display: none;
        padding: 1rem;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .asistencia-mobile-container {
            display: flex;
            flex-direction: column;
        }
    }

    .asistencia-student-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .student-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .student-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
    }

    .student-number {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .attendance-controls {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .attendance-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .attendance-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .attendance-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .attendance-option:hover {
        border-color: #d1d5db;
    }

    .attendance-option.selected-present {
        border-color: #10b981;
        background-color: #ecfdf5;
    }

    .attendance-option.selected-absent {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .attendance-option.selected-late {
        border-color: #f59e0b;
        background-color: #fffbeb;
    }

    .attendance-option i {
        margin-bottom: 0.25rem;
    }

    .attendance-option span {
        font-size: 0.75rem;
        font-weight: 500;
    }

    .attendance-option.selected-present span {
        color: #10b981;
    }

    .attendance-option.selected-absent span {
        color: #ef4444;
    }

    .attendance-option.selected-late span {
        color: #f59e0b;
    }

    .justified-checkbox-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .justified-checkbox {
        display: inline-flex;
        align-items: center;
    }

    .justified-checkbox input {
        height: 1rem;
        width: 1rem;
        color: #3b82f6;
    }

    .justified-checkbox span {
        margin-left: 0.5rem;
        font-size: 0.875rem;
    }

    .action-buttons-container {
        padding: 1.5rem;
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .action-buttons-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    @media (min-width: 640px) {
        .action-buttons-wrapper {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 0;
        }
    }

    .student-count {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .quick-actions {
            flex-direction: row;
            gap: 0.75rem;
        }
    }

    .quick-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        border-radius: 0.375rem;
        color: #374151;
        background-color: white;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .quick-action-btn:hover {
        background-color: #f0fdf4;
        border-color: #bbf7d0;
    }

    .save-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border: 1px solid transparent;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        color: white;
        background-color: #3b82f6;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .save-btn:hover {
        background-color: #2563eb;
    }

    .save-btn:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
        box-shadow: 0 0 0 2px #93c5fd;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state-icon {
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 4rem;
        width: 4rem;
        border-radius: 50%;
        background-color: #f3f4f6;
    }

    .empty-state-icon i {
        color: #9ca3af;
        font-size: 1.25rem;
    }

    .empty-state-title {
        margin-top: 1rem;
        font-size: 1.125rem;
        font-weight: 500;
        color: #111827;
    }

    .empty-state-subtitle {
        margin-top: 0.5rem;
        color: #6b7280;
    }

    /* ===== TOTALES STYLES ===== */
    .stats-container {
        margin-bottom: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .stat-card {
        border: 1px solid;
        border-radius: 0.5rem;
    }

    .stat-card-primary {
        border-color: #3b82f6;
    }

    .stat-card-success {
        border-color: #10b981;
    }

    .stat-card-info {
        border-color: #06b6d4;
    }

    .stat-card-body {
        padding: 1rem;
    }

    .stat-content {
        display: flex;
        align-items: center;
    }

    .stat-icon {
        border-radius: 50%;
        padding: 0.5rem;
        margin-right: 0.75rem;
    }

    .stat-icon-primary {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .stat-icon-success {
        background-color: rgba(16, 185, 129, 0.1);
    }

    .stat-icon-info {
        background-color: rgba(6, 182, 212, 0.1);
    }

    .stat-text {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        color: #6b7280;
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    .stat-value {
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .totales-mobile-container {
        display: none;
        padding: 1rem;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .totales-mobile-container {
            display: flex;
            flex-direction: column;
        }
    }

    .totales-student-card {
        border: 1px solid;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .totales-student-card.high-attendance {
        border-color: #bbf7d0;
        background-color: #ecfdf5;
    }

    .totales-student-card.medium-attendance {
        border-color: #fed7aa;
        background-color: #fffbeb;
    }

    .totales-student-card.low-attendance {
        border-color: #fecaca;
        background-color: #fef2f2;
    }

    .student-name-mobile {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.75rem;
    }

    .percentage-container {
        margin-bottom: 0.75rem;
    }

    .percentage-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.25rem;
    }

    .percentage-label {
        font-size: 0.75rem;
        color: #4b5563;
    }

    .percentage-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
    }

    .progress-bar {
        background-color: #e5e7eb;
        border-radius: 9999px;
        height: 0.5rem;
    }

    .progress-fill {
        height: 0.5rem;
        border-radius: 9999px;
    }

    .progress-fill.high {
        background-color: #10b981;
    }

    .progress-fill.medium {
        background-color: #f59e0b;
    }

    .progress-fill.low {
        background-color: #ef4444;
    }

    .stats-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        font-size: 0.75rem;
    }

    .stat-detail {
        text-align: center;
    }

    .stat-detail-label {
        color: #6b7280;
    }

    .stat-detail-value {
        font-weight: 600;
        color: #111827;
    }

    .stat-detail-value.present {
        color: #10b981;
    }

    .stat-detail-value.absent {
        color: #ef4444;
    }

    .stat-detail-value.late {
        color: #f59e0b;
    }

    /* ===== NOTAS STYLES ===== */
    .notas-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
    }

    .notas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .main-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .main-subtitle {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 0;
    }

    .stats-card {
        border: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-card h6 {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .stats-card .h2 {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .stats-item {
        padding: 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .stats-item:hover {
        background-color: #f8f9fa;
    }

    .stats-item h3 {
        font-size: 1.75rem;
        margin-bottom: 0.25rem;
    }

    .progress-container .progress {
        height: 0.75rem;
        border-radius: 0.375rem;
        background-color: #e5e7eb;
    }

    .progress-bar {
        border-radius: 0.375rem;
        transition: width 0.6s ease;
    }

    .notas-table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .notas-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 0.75rem;
    }

    .notas-table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .notas-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .notas-table input[type="number"] {
        width: 70px;
        margin: 0 auto;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .notas-table input[type="number"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .mobile-notas-container .card {
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        margin-bottom: 1rem;
    }

    .mobile-notas-container .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .mobile-notas-container .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
    }

    .mobile-notas-container .form-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .mobile-notas-container input[type="number"] {
        font-size: 0.875rem;
        text-align: center;
        border-radius: 0.375rem;
    }

    .badge-estado {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 500;
    }

    .badge-promedio {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }

    /* Estados específicos para notas */
    .badge-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .badge-secondary {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }

    .badge-light {
        background-color: #fefefe;
        color: #818182;
        border: 1px solid #fdfdfe;
    }

    /* Animaciones para mensajes de notas */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .mensaje-notas {
        animation: slideInRight 0.3s ease-out;
    }

    /* Progress bar animations */
    .progress-bar-animated {
        background-size: 1rem 1rem;
        animation: progress-bar-stripes 1s linear infinite;
    }

    @keyframes progress-bar-stripes {
        0% {
            background-position: 1rem 0;
        }

        100% {
            background-position: 0 0;
        }
    }

    /* Cards de estadísticas con gradientes */
    .bg-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }

    /* Mejoras para los inputs de notas */
    .form-control-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }

    .table-responsive {
        border-radius: 0.5rem;
    }

    /* Estilos específicos para el dashboard de notas */
    .header-content {
        text-align: center;
        padding: 1rem 0;
    }

    .card-header h5 {
        color: #495057;
        font-weight: 600;
    }

    .btn-group .btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    /* ===== RESPONSIVE UTILITIES ===== */
    @media (max-width: 768px) {
        .mobile-responsive {
            padding: 0.5rem !important;
        }

        .mobile-text-center {
            text-align: center !important;
        }

        .mobile-mb-3 {
            margin-bottom: 1rem !important;
        }

        .main-title {
            font-size: 1.5rem;
        }

        .stats-card .h2 {
            font-size: 1.5rem;
        }

        .stats-card h6 {
            font-size: 0.7rem;
        }

        .notas-table input[type="number"] {
            width: 60px;
            font-size: 0.8rem;
        }
    }
</style>

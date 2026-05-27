<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error al cargar orden</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .error-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        
        .error-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        .error-title {
            color: #dc3545;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #6c757d;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border-left: 4px solid #dc3545;
        }
        
        .orden-id {
            font-weight: bold;
            color: #495057;
        }
        
        .btn-volver {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .btn-volver:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1 class="error-title">Error al cargar la orden</h1>
        
        @if(isset($error))
            <div class="error-message">
                {{ $error }}
            </div>
        @endif
        
        @if(isset($ordenId))
            <p>Orden ID: <span class="orden-id">{{ $ordenId }}</span></p>
        @endif
        
        <p>Por favor, intente nuevamente o contacte al administrador del sistema.</p>
        
        <a href="javascript:history.back()" class="btn-volver">Volver atrás</a>
    </div>
</body>
</html>
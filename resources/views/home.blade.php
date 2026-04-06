<div class="row">
  <!-- Caja 1: Órdenes de Compras -->
  <div class="col-md-6 col-lg-3 mb-3">
    <a href="/ordenes/menu" style="text-decoration: none; color: inherit;">
      <div class="info-box bg-gradient-info">
        <span class="info-box-icon">
          <i class="fas fa-file-invoice-dollar"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Órdenes de Compras</span>
          <span class="info-box-number">{{ number_format($totalOrdenes) }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: {{ $porcentajeordenes['porcentaje_pendientes'] }}%"></div>
          </div>
          <span class="progress-description">
            <i class="fas fa-clock"></i> Hoy: {{ number_format($ordenesHoy) }} nuevas
          </span>
        </div>
      </div>
    </a>
  </div>

  <!-- Caja 2: Proveedores Activos -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="info-box bg-gradient-success" style="cursor: pointer;" onclick="window.location.href='/proveedor';">
      <span class="info-box-icon">
        <i class="fas fa-truck-loading"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Proveedores Activos</span>
        <span class="info-box-number">{{ number_format($proveedores) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 85%"></div>
        </div>
        <span class="progress-description">
          <i class="fas fa-clock"></i> 
        </span>
      </div>
    </div>
  </div>

  <!-- Caja 3: Ordenes Diarias -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="info-box bg-gradient-warning" style="cursor: pointer;" onclick="window.location.href='/reporte';">
      <span class="info-box-icon">
        <i class="fas fa-calendar-day"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Ordenes Diarias</span>
        <span class="info-box-number">{{ number_format($totalOrdenes) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">
          <i class="fas fa-clock"></i> Hoy: {{ number_format($ordenesHoy) }} Nuevas
        </span>
      </div>
    </div>
  </div>

  <!-- Caja 4: Ejemplo adicional para completar 4 columnas -->
  
</div>
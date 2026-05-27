<!-- Modal -->
<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="modalFacturaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalFacturaLabel">
          <i class="fas fa-file-invoice-dollar"></i> Gestionar Factura
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formularioFactura">
          <!-- Combo Box Responsable -->
          <div class="form-group">
            <label for="responsable"><strong>Responsable</strong></label>
            <select class="form-control" id="responsable" name="responsable" required>
              <option value="">Seleccionar responsable...</option>
              <option value="1">Juan Pérez</option>
              <option value="2">María García</option>
              <option value="3">Carlos López</option>
              <option value="4">Ana Martínez</option>
            </select>
          </div>

          <!-- Campo Número de Factura/Nota -->
          <div class="form-group">
            <label for="numeroDocumento"><strong>Número de Factura / Nota de Entrega</strong></label>
            <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Ej: FV-001234 o NE-005678" required>
          </div>

          <!-- Combo Box Tipo de Factura -->
          <div class="form-group">
            <label for="tipoFactura"><strong>Tipo de Factura</strong></label>
            <select class="form-control" id="tipoFactura" name="tipoFactura" required>
              <option value="">Seleccionar tipo...</option>
              <option value="factura">Factura</option>
              <option value="notaEntrega">Nota de Entrega</option>
              <option value="recibo">Recibo</option>
              <option value="notaCredito">Nota de Crédito</option>
            </select>
          </div>

          <!-- Checkbox Aprobado -->
          <div class="form-group form-check mt-3">
            <input type="checkbox" class="form-check-input" id="aprobado" name="aprobado">
            <label class="form-check-label" for="aprobado">
              <strong>✓ Aprobado</strong>
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="button" class="btn btn-success" id="btnGuardar">
          <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Botón para abrir modal (ejemplo) -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalFactura">
  <i class="fas fa-plus-circle"></i> Abrir Modal
</button>

<!-- Scripts necesarios -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<script>
  // Validar y guardar
  document.getElementById('btnGuardar').addEventListener('click', function() {
    const form = document.getElementById('formularioFactura');
    
    if (!form.checkValidity()) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos Requeridos',
        text: 'Por favor completa todos los campos obligatorios',
        confirmButtonColor: '#ffc107',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    const responsable = document.getElementById('responsable').options[document.getElementById('responsable').selectedIndex].text;
    const numeroDocumento = document.getElementById('numeroDocumento').value;
    const tipoFactura = document.getElementById('tipoFactura').options[document.getElementById('tipoFactura').selectedIndex].text;
    const aprobado = document.getElementById('aprobado').checked ? 'Sí' : 'No';

    Swal.fire({
      title: '¿Confirmar Datos?',
      html: `
        <div style="text-align: left; background: #f8f9fa; padding: 15px; border-radius: 5px;">
          <p><strong>Responsable:</strong> ${responsable}</p>
          <p><strong>Número:</strong> ${numeroDocumento}</p>
          <p><strong>Tipo:</strong> ${tipoFactura}</p>
          <p><strong>Aprobado:</strong> ${aprobado}</p>
        </div>
      `,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d',
      confirmButtonText: '<i class="fas fa-check"></i> Guardar',
      cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: '¡Guardado!',
          text: 'La factura ha sido guardada exitosamente',
          confirmButtonColor: '#28a745',
          confirmButtonText: 'Aceptar',
          didClose: () => {
            // Cerrar modal después de aceptar
            $('#modalFactura').modal('hide');
            // Aquí irías el código para enviar a tu servidor Laravel
            // ejemplo: enviarAlServidor(datos);
          }
        });
      }
    });
  });

  // Cerrar modal y limpiar formulario
  $('#modalFactura').on('hidden.bs.modal', function () {
    document.getElementById('formularioFactura').reset();
  });
</script>
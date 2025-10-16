@extends('adminlte::page')

@section('title', 'Orden de Compras')

@section('content_header')
    <h1>Crear Orden de Compra</h1>
@stop

@section('content')
<form id="ordenForm">
    @csrf

    {{-- 🔹 SECCIÓN SUCURSAL --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="sucursalSelect">Sucursal</label>
                <select id="sucursalSelect" name="id_sucursal" class="form-control" required>
                    <option value="">Seleccione una sucursal</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 🔹 FILA 1: Proveedor, RIF, Fecha --}}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="proveedorInput">Proveedor</label>
                <div class="input-group">
                    <input type="text" id="proveedorInput" class="form-control"
                           placeholder="Escriba el nombre del proveedor..."
                           autocomplete="off">
                    <input type="hidden" id="proveedor_id" name="proveedor_id">
                    <div class="input-group-append">
                        <button type="button" id="btnBuscarProveedor" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
                <div id="listaProveedores" class="border mt-1" style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; background:white; width:100%;"></div>
                <small class="form-text text-muted">Escriba y presione Buscar o haga clic en un proveedor de la lista</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="rif">RIF</label>
                <input type="text" id="rif" class="form-control" readonly placeholder="RIF del proveedor">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" readonly>
            </div>
        </div>
    </div>

    {{-- 🔹 FILA 2: Teléfono y Correo --}}
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" class="form-control" readonly placeholder="Teléfono del proveedor">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="text" id="correo" class="form-control" readonly placeholder="Correo del proveedor">
            </div>
        </div>
    </div>

    <hr>

    {{-- 🔹 PRODUCTOS --}}
    <h4>Productos</h4>

    <div class="mb-2">
        <button type="button" id="btnAgregarProducto" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Producto
        </button>
    </div>

    <table class="table table-bordered table-striped" id="productosTable">
        <thead class="bg-primary text-white">
            <tr>
                <th>Producto</th>
                <th style="width: 100px;">Cantidad</th>
                <th style="width: 150px;">Unidad</th>
                <th style="width: 150px;">Precio Unitario</th>
                <th style="width: 150px;">Total</th>
                <th style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    {{-- 🔹 MONEDA Y TASA --}}
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="form-group">
                <label for="monedaSelect">Moneda</label>
                <select id="monedaSelect" class="form-control">
                    <option value="usd">Dólar ($)</option>
                    <option value="eur">Euro (€)</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="tasaDia">Tasa del Día</label>
                <input type="text" id="tasaDia" class="form-control" readonly placeholder="Cargando...">
            </div>
        </div>
    </div>

    {{-- 🔹 IVA Y TOTALES --}}
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="ivaCheck">
                <label class="form-check-label" for="ivaCheck">Aplicar IVA (16%)</label>
            </div>
        </div>

        <div class="col-md-4 text-right">
            <h5><strong>Total General: </strong><span id="totalGeneral">0.00</span></h5>
            <h6><strong>Total con IVA: </strong><span id="totalConIva">0.00</span></h6>
            <h6><strong>Equivalente en Bs: </strong><span id="totalEnBs">0.00</span></h6>
        </div>
    </div>

    <button type="submit" class="btn btn-success mt-3">Guardar Orden</button>
</form>
@stop


@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const proveedores = @json($proveedores);
const unidades = @json($unidades);

document.addEventListener('DOMContentLoaded', async function() {
    const sucursalSelect = document.getElementById('sucursalSelect');
    const proveedorInput = document.getElementById('proveedorInput');
    const proveedorIdInput = document.getElementById('proveedor_id');
    const btnBuscar = document.getElementById('btnBuscarProveedor');
    const listaProveedores = document.getElementById('listaProveedores');
    const tablaProductos = document.querySelector('#productosTable tbody');
    const totalGeneral = document.getElementById('totalGeneral');
    const totalConIva = document.getElementById('totalConIva');
    const totalEnBs = document.getElementById('totalEnBs');
    const ivaCheck = document.getElementById('ivaCheck');
    const tasaDia = document.getElementById('tasaDia');
    const btnAgregarProducto = document.getElementById('btnAgregarProducto');
    const monedaSelect = document.getElementById('monedaSelect');
    let tasas = null;

    // 🔹 Cargar sucursales
    async function cargarSucursales() {
        try {
            const res = await fetch('{{ url("/consultar/sucursales") }}');
            const data = await res.json();
            sucursalSelect.innerHTML = '<option value="">Seleccione una sucursal</option>';
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach((s) => {
                    const idSucursal = s.id ?? s.id_sucursal;
                    sucursalSelect.innerHTML += `<option value="${idSucursal}">${s.nombre}</option>`;
                });
            } else {
                sucursalSelect.innerHTML = '<option value="">No hay sucursales disponibles</option>';
            }
        } catch (error) {
            console.error("Error cargando sucursales:", error);
            sucursalSelect.innerHTML = '<option value="">Error al cargar</option>';
        }
    }
    await cargarSucursales();

    // 🔹 Proveedores
    function mostrarProveedores(filtrados) {
        if (!filtrados.length) {
            listaProveedores.innerHTML = '<div class="proveedor-item text-muted">No se encontraron proveedores</div>';
            listaProveedores.style.display = 'block';
            return;
        }
        listaProveedores.innerHTML = filtrados.map(p => `
            <div class="proveedor-item" data-id="${p.id_proveedor || p.id}" 
                 data-rif="${p.rif}" data-telefono="${p.telefono || ''}" data-correo="${p.correo || ''}">
                 <strong>${p.nombre}</strong> - ${p.rif}
            </div>`).join('');
        listaProveedores.style.display = 'block';
        listaProveedores.querySelectorAll('.proveedor-item').forEach(item => {
            item.addEventListener('click', () => seleccionarProveedor(item));
        });
    }

    function seleccionarProveedor(el) {
        proveedorInput.value = el.textContent.split(' - ')[0];
        proveedorIdInput.value = el.dataset.id;
        document.getElementById('rif').value = el.dataset.rif;
        document.getElementById('telefono').value = el.dataset.telefono;
        document.getElementById('correo').value = el.dataset.correo;
        listaProveedores.style.display = 'none';
    }

    btnBuscar.addEventListener('click', () => mostrarProveedores(proveedores));
    proveedorInput.addEventListener('input', () => {
        const texto = proveedorInput.value.toLowerCase();
        const filtrados = proveedores.filter(p => p.nombre.toLowerCase().includes(texto) || p.rif.toLowerCase().includes(texto));
        mostrarProveedores(filtrados);
    });
    document.addEventListener('click', e => {
        if (!e.target.closest('#listaProveedores') && !e.target.closest('#proveedorInput')) listaProveedores.style.display = 'none';
    });

    // 🔹 Productos dinámicos
    function generarSelectUnidades() {
        return `<select name="id_unidad[]" class="form-control unidadSelect">
            <option value="">Seleccione unidad</option>
            ${unidades.map(u => `<option value="${u.id_unidad || u.id}">${u.nombre} (ID: ${u.id_unidad || u.id})</option>`).join('')}
        </select>`;
    }

    function agregarFila() {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td><input type="text" name="producto[]" class="form-control" placeholder="Descripción del producto"></td>
            <td><input type="number" name="cantidad[]" class="form-control cantidad" min="1" value="1"></td>
            <td>${generarSelectUnidades()}</td>
            <td><input type="number" name="precio[]" class="form-control precio" min="0" step="0.01" value="0.00"></td>
            <td><input type="text" class="form-control total" readonly value="0.00"></td>
            <td><button type="button" class="btn btn-danger btn-sm eliminarFila"><i class="fas fa-trash"></i></button></td>`;
        tablaProductos.appendChild(fila);

        fila.querySelector('.cantidad').addEventListener('input', () => calcularFila(fila));
        fila.querySelector('.precio').addEventListener('input', () => calcularFila(fila));
        fila.querySelector('.eliminarFila').addEventListener('click', () => { fila.remove(); calcularTotalGeneral(); });

        calcularTotalGeneral();
    }

    function calcularFila(fila) {
        const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(fila.querySelector('.precio').value) || 0;
        fila.querySelector('.total').value = (cantidad * precio).toFixed(2);
        calcularTotalGeneral();
    }

    function calcularTotalGeneral() {
        let total = 0;
        document.querySelectorAll('.total').forEach(t => total += parseFloat(t.value) || 0);
        totalGeneral.textContent = total.toFixed(2);
        const final = ivaCheck.checked ? total * 1.16 : total;
        totalConIva.textContent = final.toFixed(2);
        totalEnBs.textContent = (final * (parseFloat(tasaDia.value) || 0)).toFixed(2);
    }

    btnAgregarProducto.addEventListener('click', agregarFila);
    ivaCheck.addEventListener('change', calcularTotalGeneral);
    agregarFila(); // fila inicial

    // 🔹 Obtener tasa
    async function obtenerTasas() {
        try {
            const res = await fetch('https://api.dolarvzla.com/public/exchange-rate');
            const data = await res.json();
            tasas = data.current;
            actualizarTasa();
        } catch {
            tasaDia.value = 'Error';
        }
    }

    function actualizarTasa() {
        if (!tasas) return;
        const tipo = monedaSelect.value;
        tasaDia.value = tipo === 'usd' ? tasas.usd.toFixed(2) : tasas.eur.toFixed(2);
        calcularTotalGeneral();
    }

    monedaSelect.addEventListener('change', actualizarTasa);
    await obtenerTasas();

    // 🔹 Guardar orden
    document.getElementById('ordenForm').addEventListener('submit', async e => {
        e.preventDefault();

        const proveedor_id = proveedorIdInput.value;
        const id_sucursal = sucursalSelect.value;

        if (!proveedor_id || !id_sucursal) {
            return Swal.fire('Atención', 'Seleccione proveedor y sucursal', 'warning');
        }

        const productos = [...tablaProductos.querySelectorAll('tr')].map(fila => {
            const producto = fila.querySelector('input[name="producto[]"]').value.trim();
            const cantidad = parseFloat(fila.querySelector('input[name="cantidad[]"]').value) || 0;
            const precio = parseFloat(fila.querySelector('input[name="precio[]"]').value) || 0;
            const selectUnidad = fila.querySelector('select[name="id_unidad[]"]');
            const id_unidad = selectUnidad ? parseInt(selectUnidad.value) || null : null;

            return { producto, cantidad, precio, id_unidad };
        }).filter(p => p.producto && p.id_unidad && p.cantidad > 0 && p.precio > 0);

        console.log("Productos a enviar:", productos); // 👀 Verificar en consola

        const datos = {
            proveedor_id: parseInt(proveedor_id),
            id_sucursal: parseInt(id_sucursal),
            fecha: document.getElementById('fecha').value,
            moneda: monedaSelect.value,
            tasa: parseFloat(tasaDia.value) || 0,
            aplicarIva: ivaCheck.checked,
            productos
        };

        const res = await fetch('{{ route("ordenes.guardar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify(datos)
        });
        const r = await res.json();
        Swal.fire(res.ok ? 'Éxito' : 'Error', r.message || '', res.ok ? 'success' : 'error')
            .then(() => res.ok && window.location.reload());
    });
});
</script>
@stop

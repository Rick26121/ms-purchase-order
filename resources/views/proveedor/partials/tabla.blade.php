@if($proveedor->count() > 0)
    @foreach($proveedor as $item)
    <tr>
        <td>{{ $item->id_proveedor }}</td>
        <td>{{ $item->nombre }}</td>
        <td>{{ $item->rif }}</td>
        <td>{{ $item->correo ?? 'N/A' }}</td>
        <td>{{ $item->telefono ?? 'N/A' }}</td>
        <td>
            <button type="button" class="btn btn-info btn-sm btn-ver-proveedor mr-1" 
                    data-id="{{ $item->id_proveedor }}">
                <i class="fas fa-eye"></i> Ver
            </button>
            <button type="button" class="btn btn-primary btn-sm btn-editar-proveedor" 
                    data-id="{{ $item->id_proveedor }}">
                <i class="fas fa-edit"></i> Editar
            </button>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center">No hay proveedores registrados</td>
    </tr>
@endif
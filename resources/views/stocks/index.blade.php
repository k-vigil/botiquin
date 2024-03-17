@extends('shared.index')

@section('content')
<div class="mb-3">
    <a href="/dashboard">
        <i class="fas fa-chevron-left"></i>
        <span class="ml-1">Volver</span>
    </a>
    <h5 class="font-weight-semibold">Stocks</h5>
</div>
<div class="table-responsive">
    <table class="table table-borderless table-hover dt-table">
        <thead>
            <tr>
                <th class="font-weight-semibold">#</th>
                <th class="font-weight-semibold">Laboratorio</th>
                <th class="font-weight-semibold">Codigo</th>
                <th class="font-weight-semibold" style="width: 220px;">Descripcion</th>
                <th class="font-weight-semibold">Registro DNM</th>
                <th class="font-weight-semibold">Cantidad</th>
                <th class="font-weight-semibold">Precio</th>
                <th class="font-weight-semibold">Lote</th>
                <th class="font-weight-semibold">Vencimiento</th>
            </tr>
        </thead>
        <tbody id="tbody"></tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('stocks').classList.add('active')
</script>
<script>
    async function listarCategorias() {
        const res = await http.get('/stocks')
        const {
            data
        } = res
        let html = ''

        data.map(i => {
            html += `
                <tr>
                    <td style="width: 80px;">${i.id}</td>
                    <td>${i.medicamento_presentacion.medicamento.laboratorio.nombre}</td>
                    <td>${i.medicamento_presentacion.codigo}</td>
                    <td style="width: 220px;">${i.medicamento_presentacion.descripcion}</td>
                    <td>${i.medicamento_presentacion.registro_dnm}</td>
                    <td>${i.cantidad}</td>
                    <td>$${i.precio.toFixed(2) }</td>
                    <td>${i.lote.codigo}</td>
                    <td>${i.lote.vencimiento}</td>
                </tr>
            `
        });

        $('.dt-table').DataTable().destroy()
        document.getElementById('tbody').innerHTML = html
        $('.dt-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
            }
        })
    }

    listarCategorias()
</script>
@endpush

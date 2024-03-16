@extends('shared.index')

@push('links')
<style>
    #pills-tab {
        border-bottom: 2px solid #DFE1E6 !important;
    }

    #pills-tab .nav-link.active {
        color: var(--blue) !important;
        position: relative;
    }

    #pills-tab .nav-link.active::after {
        background-color: var(--blue);
        bottom: -1.5px;
        content: '';
        height: 2px;
        left: 0;
        position: absolute;
        width: 100%;
    }
</style>
@endpush()

@section('content')
<div>
    <div class="mb-3">
        <a href="/dashboard">
            <i class="fas fa-chevron-left"></i>
            <span class="ml-1">Volver</span>
        </a>
        <h5 class="font-weight-semibold">Reportes</h5>
    </div>

    <ul class="nav nav-pills border-bottom" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link py-3 bg-white border-0 rounded-0 active" id="`pills-vencidos-tab`" data-toggle="pill" data-target="#pills-vencidos" type="button" role="tab" aria-controls="pills-vencidos" aria-selected="false">Vencimientos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-3 bg-white border-0 rounded-0" id="pills-por-categorias-tab" data-toggle="pill" data-target="#pills-por-categorias" type="button" role="tab" aria-controls="pills-por-categorias" aria-selected="false">Por categorias</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-3 bg-white border-0 rounded-0" id="pills-por-laboratorios-tab" data-toggle="pill" data-target="#pills-por-laboratorios" type="button" role="tab" aria-controls="pills-por-laboratorios" aria-selected="false">Por laboratorios</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-3 bg-white border-0 rounded-0" id="pills-por-lotes-tab" data-toggle="pill" data-target="#pills-por-lotes" type="button" role="tab" aria-controls="pills-por-lotes" aria-selected="false">Por lotes</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-3 bg-white border-0 rounded-0" id="pills-inventario-tab" data-toggle="pill" data-target="#pills-inventario" type="button" role="tab" aria-controls="pills-inventario" aria-selected="true">Inventario</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- vencidos -->
        <div class="tab-pane py-4 show active" id="pills-vencidos" role="tabpanel" aria-labelledby="pills-vencidos-tab">

            <h6 class="mb-3">Reporte de vencimientos</h6>
            <form action="/reportes/vencimientos" method="post" target="_blank">
                @csrf
                <div class="row align-items-end">
                    <div class="col-sm-12 col-md-3 form-group">
                        <label for="" class="font-weight-semibold">Fecha vencimiento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="fecha" required>
                    </div>
                    <div class="col-sm-12 col-md-2 form-group">
                        <button type="submit" class="btn btn-light font-weight-semibold">Generar</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- por categorias -->
        <div class="tab-pane py-4" id="pills-por-categorias" role="tabpanel" aria-labelledby="pills-por-categorias-tab">

            <h6 class="mb-3">Reporte de medicamentos por categorias</h6>
            <form action="/reportes/porcategoria" method="post" target="_blank">
                @csrf
                <div class="row align-items-end">
                    <div class="col-sm-12 col-md-3 form-group">
                        <label for="" class="font-weight-semibold">Categoria <span class="text-danger">*</span></label>
                        <select class="form-control" id="categorias-select" name="categoria" required>
                            <option value="">Elegir opcion</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2 form-group">
                        <button type="submit" class="btn btn-light font-weight-semibold">Generar</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- por laboratorios -->
        <div class="tab-pane py-4" id="pills-por-laboratorios" role="tabpanel" aria-labelledby="pills-por-laboratorios-tab">

            <h6 class="mb-3">Reporte de medicamentos por laboratorios</h6>
            <form action="/reportes/porlaboratorio" method="post" target="_blank">
                @csrf
                <div class="row align-items-end">
                    <div class="col-sm-12 col-md-3 form-group">
                        <label for="" class="font-weight-semibold">Laboratorio <span class="text-danger">*</span></label>
                        <select class="form-control" id="laboratorios-select" name="laboratorio" required>
                            <option value="">Elegir opcion</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2 form-group">
                        <button type="submit" class="btn btn-light font-weight-semibold">Generar</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- por lotes -->
        <div class="tab-pane py-4" id="pills-por-lotes" role="tabpanel" aria-labelledby="pills-por-lotes-tab">

            <h6 class="mb-3">Reporte de medicamentos por lotes</h6>
            <form action="/reportes/porlote" method="post" target="_blank">
                @csrf
                <div class="row align-items-end">
                    <div class="col-sm-12 col-md-3 form-group">
                        <label for="" class="font-weight-semibold">Lote <span class="text-danger">*</span></label>
                        <select class="form-control" id="lotes-select" name="lote" required>
                            <option value="">Elegir opcion</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2 form-group">
                        <button type="submit" class="btn btn-light font-weight-semibold">Generar</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- inventario -->
        <div class="tab-pane py-4" id="pills-inventario" role="tabpanel" aria-labelledby="pills-inventario-tab">

            <h6 class="mb-3">Reporte de inventario</h6>
            <form action="/reportes/inventario" method="post" target="_blank">
                @csrf
                <button type="submit" class="btn btn-light font-weight-semibold">Generar</button>
            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.getElementById('reportes').classList.add('active')
</script>
<script>
    async function listarCategorias() {
        const res = await http.get('/categorias')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.nombre}</option>
        `);

        document.getElementById('categorias-select').innerHTML = html
    }

    async function listarLaboratorios() {
        const res = await http.get('/laboratorios')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.nombre}</option>
        `);

        document.getElementById('laboratorios-select').innerHTML = html
    }

    async function listarLotes() {
        const res = await http.get('/lotes')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.codigo} — ${i.vencimiento}</option>
        `);

        document.getElementById('lotes-select').innerHTML = html
    }

    listarCategorias()
    listarLaboratorios()
    listarLotes()
</script>
@endpush

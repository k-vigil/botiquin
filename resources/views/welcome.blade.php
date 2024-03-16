@extends('shared.index')

@section('content')

<div class="row">
    <div class="col-sm-12 col-lg-3 mb-3">
        <div class="info-box border border-light shadow-sm">
            <span class="info-box-icon bg-purple"><i class="fas fa-folder-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total en entradas</span>
                <h5 class="info-box-number" id="total-entradas">$00.00</h5>
            </div>

        </div>
    </div>
    <div class="col-sm-12 col-lg-3 mb-3">
        <div class="info-box border border-light shadow-sm">
            <span class="info-box-icon bg-teal"><i class="fas fa-folder-minus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total en salidas</span>
                <h5 class="info-box-number" id="total-salidas">$00.00</h5>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-8 mb-3">
        <div class="card shadow-sm border border-light">
            <div class="card-header">
                <h6 class="font-weight-semibold">Medicamentos con limite de stock minimo</h6>
            </div>
            <div class="card-body px-0 py-1">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Laboratorio</th>
                                <th>Codigo</th>
                                <th>Medicamento</th>
                                <th class="text-right">Disponible</th>
                                <th>Stock minimo</th>
                            </tr>
                        </thead>
                        <tbody id="stock-meds"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 mb-3">
        <div class="card shadow-sm border border-light">
            <div class="card-header">
                <h6 class="font-weight-semibold">Top 3 medicamentos mas descargados</h6>
            </div>
            <div class="card-body" id="top-medicamentos">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('dashboard').classList.add('active')
</script>
<script>
    async function costoTotalEntradas() {
        const res = await http.get('/dashboard/costo/entradas')
        const {
            data
        } = res

        document.getElementById('total-entradas').innerText = `$${Intl.NumberFormat('en-US', { minimumFractionDigits: 2}).format(parseFloat(data.total ?? 0))}`
    }

    async function costoTotalSalidas() {
        const res = await http.get('/dashboard/costo/salidas')
        const {
            data
        } = res

        document.getElementById('total-salidas').innerText = `$${Intl.NumberFormat('en-US', { minimumFractionDigits: 2}).format(parseFloat(data.total ?? 0))}`
    }

    async function listarTopMedicamentosMasDescargados() {
        const res = await http.get('/dashboard/top')
        const {
            data
        } = res
        let html = ''
        const colors = ['bg-primary', 'bg-purple', 'bg-teal']

        data.forEach((i, j) => {
            html += `
                <div class="mb-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="span ${colors[j]} rounded-circle d-inline-block" style="height: 8px; width: 8px;"></span>
                        <p class="mb-0 ml-3">${i.descripcion}</p>
                    </div>
                    <h6 class="mb-0">${parseInt(i.total)}</h6>
                </div>
            `
        })

        if (html == "")
            html = `<p>No hay datos</p>`

        document.getElementById('top-medicamentos').innerHTML = html
    }

    async function listarMedicamentosConLimiteDeStockMinimo() {
        const res = await http.get('/dashboard/stock')
        const {
            data
        } = res
        let html = ''

        data.forEach((i, j) => {
            html += `
                <tr>
                    <td>${j+1}</td>
                    <td>${i.lab}</td>
                    <td>${i.codigo}</td>
                    <td>${i.descripcion}</td>
                    <td class="text-right">${i.cantidad}</td>
                    <td>${i.stock_min}</td>
                </tr>
            `
        })

        if (html == "")
            html = `<tr><td class="text-center" colspan="6">No hay datos</td></tr>`

        document.getElementById('stock-meds').innerHTML = html
    }

    costoTotalEntradas()
    costoTotalSalidas()
    listarTopMedicamentosMasDescargados()
    listarMedicamentosConLimiteDeStockMinimo()
</script>
@endpush

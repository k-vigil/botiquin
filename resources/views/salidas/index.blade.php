@extends('shared.index')

@push('links')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
@endpush

@section('content')
<div style="max-width: 980px;">
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <a href="/dashboard">
                    <i class="fas fa-chevron-left"></i>
                    <span class="ml-1">Volver</span>
                </a>
                <h5 class="font-weight-semibold">Salidas</h5>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-light font-weight-semibold" data-toggle="modal" data-target="#modalRegistrar">
                    Nueva salida
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-hover dt-table">
            <thead>
                <tr>
                    <th class="font-weight-semibold">#</th>
                    <th class="font-weight-semibold">Fecha</th>
                    <th class="font-weight-semibold">Descripcon</th>
                    <th class="font-weight-semibold">Estado</th>
                    <th class="font-weight-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>
</div>

<!-- modal para registrar salida -->
<div class="modal" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalRegistrarLabel">Nueva salida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registrar">
                <div class="modal-body">

                    <div class="row">
                        <div class="mb-3 col-sm-12 col-lg-4">
                            <label for="" class="font-weight-semibold">Descripcion <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="descripcion-sal" required>
                        </div>
                        <div class="mb-3 col-sm-12 col-lg-2">
                            <label for="" class="font-weight-semibold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha-sal" required>
                        </div>
                    </div>

                    <div class="row align-items-end">
                        <div class="mb-3 col-sm-12 col-lg-4">
                            <label for="" class="font-weight-semibold">Medicamento</label>
                            <select id="select-medicamentos" class="form-control" data-live-search="true" data-style="form-control text-dark">
                                <option value="">Elegir medicamento</option>
                            </select>
                        </div>
                        <div class="mb-3 col-sm-12 col-lg-2">
                            <label for="" class="font-weight-semibold">Disponible</label>
                            <input type="number" class="form-control bg-light" id="disponible" readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-lg-2">
                            <label for="" class="font-weight-semibold">Precio</label>
                            <input type="number" class="form-control" id="precio">
                        </div>
                        <div class="mb-3 col-sm-12 col-lg-2">
                            <label for="" class="font-weight-semibold">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad">
                        </div>
                        <div class="mb-3 col-sm-12 col-lg-2">
                            <button type="button" class="btn btn-light font-weight-semibold" id="btnAgregarItem">Agregar</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mb-0">
                            <thead class="border-bottom" style="border-width: 2px !important;">
                                <tr>
                                    <th class="font-weight-semibold">Medicamento</th>
                                    <th class="font-weight-semibold" style="width: 120px;">Cantidad</th>
                                    <th class="font-weight-semibold" style="width: 120px;">Precio</th>
                                    <th class="font-weight-semibold text-right" style="width: 80px;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-detalles"></tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary font-weight-semibold">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para detalles salida -->
<div class="modal" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalDetallesLabel">Detalles salida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-lg-3 mb-3">
                        <p class="mb-0 text-muted">Id</p>
                        <p id="salida-id"></p>
                    </div>
                    <div class="col-sm-12 col-lg-3 mb-3">
                        <p class="mb-0 text-muted">Fecha</p>
                        <p id="salida-fecha"></p>
                    </div>
                    <div class="col-sm-12 col-lg-3 mb-3">
                        <p class="mb-0 text-muted">Estado</p>
                        <span class="badge" id="salida-estado"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <p class="mb-0 text-muted">Descripcion</p>
                    <p id="salida-descripcion"></p>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="border-bottom" style="border-width: 2px !important;">
                            <tr>
                                <th class="font-weight-semibold">#</th>
                                <th class="font-weight-semibold">Medicamento</th>
                                <th class="font-weight-semibold">Cantidad</th>
                                <th class="font-weight-semibold">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-salida-detalles"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal para anular salida -->
<div class="modal" id="modalAnular" tabindex="-1" aria-labelledby="modalAnularLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" style="width: 320px;">
        <div class="modal-content border-0 shadow-sm px-1">
            <div class="modal-header">
                <h5 class="modal-title font-weight-semibold" id="modalAnularLabel">Anular salida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-anular">
                <div class="modal-body">
                    <div class="text-center text-warning mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                    </div>
                    <h6 class="text-center">Deseas anular esta entrada?</h6>
                    <input type="hidden" id="id-fan">
                </div>
                <div class="modal-footer border-top-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning font-weight-semibold">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/js/i18n/defaults-es_ES.js') }}"></script>
<script>
    document.getElementById('salidas').classList.add('active')
    $('#select-medicamentos').selectpicker()
    $('#select-lotes').selectpicker()
</script>
<script>
    async function listarMedicamentos() {
        const res = await http.get('/stocks')
        const {
            data
        } = res
        let html = '<option value="">Elegir medicamento</option>'

        data.map(i => html += `
            <option value="${i.id}-${i.cantidad}-${i.precio}">${i.medicamento_presentacion.codigo} ${i.medicamento_presentacion.descripcion} — ${i.lote.codigo} / ${i.lote.vencimiento}</option>
        `);

        document.getElementById('select-medicamentos').innerHTML = html
        $('#select-medicamentos').selectpicker('refresh')
    }

    async function listarSalidas() {
        const res = await http.get('/salidas')
        const {
            data
        } = res
        let html = ''

        data.map(i => html += `
            <tr>
                <td style="width: 80px;">${i.id}</td>
                <td>${i.fecha}</td>
                <td style="120px;">${i.descripcion ?? '-'}</td>
                <td style="120px;"><span class="badge ${i.estado == 'Anulado' ? 'bg-danger' : 'bg-success'}">${i.estado}</span></td>
                <td class="text-right" style="width: 80px;">
                    <div class="btn-group align-items-center">
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalDetalles" onclick="obtenerDetallesSalida(${i.id})">Detalles</button>
                        <button type="button" class="btn btn-link px-1 py-0"  ${i.estado == 'Anulado' ? 'disabled' : ''} data-toggle="modal" data-target="#modalAnular" onclick="obtenerSalidaParaAnular(${i.id})">Anular</button>
                    </div>
                </td>
            </tr>
        `);

        $('.dt-table').DataTable().destroy()
        document.getElementById('tbody').innerHTML = html
        $('.dt-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
            }
        })
    }

    async function registrarSalida(body) {
        try {
            const res = await http.post('/salidas', body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Registro completado!',
                text: "Salida registrada exitosamente"
            })
            listarSalidas()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerSalidaParaAnular(id) {
        console.log(id);

        try {
            const res = await http.get(`/salidas/${id}`)
            const {
                data
            } = res

            document.getElementById('id-fan').value = data.id
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerDetallesSalida(id) {
        console.log(id);

        try {
            const res = await http.get(`/salidas/${id}`)
            const {
                data
            } = res
            let detallesHtml = ''

            data.detalles.forEach(i => detallesHtml += `
                <tr>
                    <td>${i.id}</td>
                    <td>${i.stock.medicamento_presentacion.descripcion}</td>
                    <td>${i.cantidad}</td>
                    <td>$${parseFloat(i.precio).toFixed(2)}</td>
                </tr>
            `)

            document.getElementById('salida-id').innerText = data.id
            document.getElementById('salida-fecha').innerText = data.fecha
            document.getElementById('salida-estado').innerText = data.estado
            document.getElementById('salida-descripcion').innerText = data.descripcion
            document.getElementById('tbody-salida-detalles').innerHTML = detallesHtml
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function anularSalida(id) {
        try {
            const res = await http.delete(`/salidas/anular/${id}`)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Eliminacion completada!',
                text: "Entrada anulada exitosamente"
            })
            listarSalidas()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    document.getElementById('form-registrar').addEventListener('submit', async function(e) {
        e.preventDefault()

        console.log('enviando formulario')
        // descripcion-entrada
        const descripcion = document.getElementById("descripcion-sal").value
        const fecha = document.getElementById("fecha-sal").value
        const listaDetalles = document.getElementById("tbody-detalles")
        const detalles = []
        let medId = 0
        let loteId = 0
        let cantidad = 0
        let precio = 0

        if (listaDetalles.children.length == 0) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Debes llenar almenos un registro"
            })
            return
        }

        for (let i of listaDetalles.children) {

            medId = i.getAttribute('data-medid')
            cantidad = i.getAttribute('data-cantidad')
            precio = i.getAttribute('data-precio')

            detalles.push({
                stock_id: medId,
                cantidad,
                precio
            })
        }

        const body = {
            descripcion,
            fecha,
            detalles
        }

        await registrarSalida(body)
        document.getElementById("descripcion-sal").value = ""
        document.getElementById("fecha-sal").value = ""
        document.getElementById("tbody-detalles").innerHTML = ""
        $('#modalRegistrar').modal('hide')
    })

    document.getElementById('form-anular').addEventListener('submit', async function(e) {
        e.preventDefault()

        // id-form-eliminar
        const id = document.getElementById("id-fan").value

        await anularSalida(id)
        document.getElementById("id-fan").value = ""
        $('#modalAnular').modal('hide')
    })

    // concerniente a registro de salidas
    let i = 0

    function agregarItem(medicamentoId, medicamento, cantidad, precio) {
        let html = `
            <tr data-index="${i}" data-medid="${medicamentoId}" data-cantidad="${cantidad}" data-precio="${precio}">
                <td>${medicamento}</td>
                <td>${cantidad}</td>
                <td>$${parseFloat(precio).toFixed(2)}</td>
                <td class="text-right">
                    <button type="button" class="btn btn-link text-danger py-0" onclick="removerItem(${i})">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `

        document.getElementById('tbody-detalles').innerHTML += html
        i++
    }

    function removerItem(index) {
        let tr = document.querySelector(`#tbody-detalles [data-index="${index}"]`)
        tr.remove()
    }

    document.getElementById('btnAgregarItem').addEventListener('click', function(e) {

        let val = $('#select-medicamentos').val()

        let medicamentoId = val.split('-')[0]
        let medicamento = $('#select-medicamentos option:selected').text()

        let disponible = document.getElementById('disponible').value
        let cantidad = document.getElementById('cantidad').value
        let precio = document.getElementById('precio').value

        if (medicamentoId == "" || cantidad == "" || cantidad == 0 || precio == "") {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Debes llenar los elementos necesarios"
            })
            return
        }

        if (parseInt(disponible) < parseInt(cantidad)) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "La cantidad de salida no debe ser mayor a la disponibilidad"
            })
            return
        }

        agregarItem(medicamentoId, medicamento, cantidad, precio)

        $('#select-medicamentos').val('')
        document.getElementById('disponible').value = ""
        document.getElementById('cantidad').value = ""
        document.getElementById('precio').value = ""
        $('#select-medicamentos').selectpicker('refresh')
    })

    $('#select-medicamentos').on('change', function(e) {
        let val = $('#select-medicamentos').val()
        let cantidad = val.split('-')[1]
        let precio = val.split('-')[2]
        document.getElementById('disponible').value = cantidad
        document.getElementById('precio').value = parseFloat(precio).toFixed(2)

        document.getElementById('cantidad').focus()
    })

    listarSalidas()
    listarMedicamentos()
</script>
@endpush

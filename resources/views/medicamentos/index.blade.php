@extends('shared.index')

@push('links')
<link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
<style>
    .step.active .bs-stepper-label {
        /* background-color: red; */
        color: var(--blue) !important;
    }
</style>
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
                <h5 class="font-weight-semibold">Medicamentos</h5>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-light font-weight-semibold" data-toggle="modal" data-target="#modalRegistrar">
                    Nuevo medicamento
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-hover dt-table">
            <thead>
                <tr>
                    <th class="font-weight-semibold">#</th>
                    <th class="font-weight-semibold">Medicamento</th>
                    <th class="font-weight-semibold">Laboratorio</th>
                    <th class="font-weight-semibold">Categoria</th>
                    <th class="font-weight-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>
</div>

<!-- template nueva variante -->
<template id="new-variante">
    <tr style="vertical-align: middle;">
        <td class="p-0" style="width: 120px;"><textarea class="form-control border-0 codigo" rows="1"></textarea></td>
        <td class="p-0"><textarea class="form-control border-0 descripcion" rows="1"></textarea></td>
        <td class="p-0"><textarea class="form-control border-0 composicion" rows="1"></textarea></td>
        <td class="p-0" style="width: 140px;"><textarea class="form-control border-0 registro_dnm" rows="1"></textarea></td>
        <td class="p-0" style="width: 140px;"><textarea class="form-control border-0 stock_min" rows="1"></textarea></td>
        <td class="p-0">
            <select class="form-control border-0 presentacion">
                <option value="">Elegir opcion</option>
            </select>
        </td>
        <td class="p-0 text-center" style="width: 40px;">
            <button type="button" class="btn btn-link text-danger btnEliminarFila p-0">
                <i class="fas fa-times"></i>
            </button>
        </td>
    </tr>
</template>

<!-- modal para registrar medicamento -->
<div class="modal" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modalDialogRegistrar">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalRegistrarLabel">Nuevo medicamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registrar">
                <div class="modal-body pb-0">

                    <div class="bs-stepper">
                        <div class="bs-stepper-header justify-content-center" role="tablist">
                            <div class="step" data-target="#first-part">
                                <button type="button" class="step-trigger btn-sm py-1" role="tab" aria-controls="first-part" id="first-part-trigger">
                                    <span class="bs-stepper-circle font-weight-semibold">1</span>
                                    <span class="bs-stepper-label font-weight-semibold text-dark">Datos generales</span>
                                </button>
                            </div>
                            <div class="step" data-target="#second-part">
                                <button type="button" class="step-trigger btn-sm py-1" role="tab" aria-controls="second-part" id="second-part-trigger">
                                    <span class="bs-stepper-circle font-weight-semibold">2</span>
                                    <span class="bs-stepper-label font-weight-semibold text-dark">Variantes</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content px-0 pb-0">
                            <div id="first-part" class="content py-3" role="tabpanel" aria-labelledby="first-part-trigger">

                                <div class="form-group">
                                    <label for="" class="font-weight-semibold">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nombre-fr" required>
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-semibold">Descripcion</label>
                                    <textarea class="form-control" id="descripcion-fr" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-semibold">Laboratorio <span class="text-danger">*</span></label>
                                    <select class="form-control" id="laboratorio-fr" required>
                                        <option value="">Elegir opcion</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-semibold">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-control" id="categoria-fr" required>
                                        <option value="">Elegir opcion</option>
                                    </select>
                                </div>

                                <br>
                                <div class="text-right">
                                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary font-weight-semibold" onclick="siguiente()">Siguiente</button>
                                </div>
                            </div>
                            <div id="second-part" class="content py-3" role="tabpanel" aria-labelledby="second-part-trigger">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-semibold" style="width: 120px;">Codigo</th>
                                                <th class="font-weight-semibold">Descripcion</th>
                                                <th class="font-weight-semibold">Composicion</th>
                                                <th class="font-weight-semibold" style="width: 140px;">Registro DNM</th>
                                                <th class="font-weight-semibold" style="width: 140px;">Stock minimo</th>
                                                <th class="font-weight-semibold">Presentacion</th>
                                                <th class="font-weight-semibold" style="width: 40px;">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-variantes"></tbody>
                                    </table>
                                </div>

                                <br>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-link" id="btnAgregarVariante">+ Agregar variante</button>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-link text-muted" onclick="anterior()">Anterior</button>
                                        <button type="submit" class="btn btn-primary font-weight-semibold">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para registrar nuevas variantes -->
<div class="modal" id="modalNuevasVariantes" tabindex="-1" aria-labelledby="modalNuevasVariantesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalNuevasVariantesLabel">Nuevas variantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-nuevas-variantes">
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4">
                            <label for="" class="font-weight-semibold">Medicamento</label>
                            <input type="hidden" id="nuevas-variantes-med-id">
                            <input type="text" class="form-control bg-light" id="nuevas-variantes-med-nombre" readonly>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <label for="" class="font-weight-semibold">Laboratorio</label>
                            <input type="text" class="form-control bg-light" id="nuevas-variantes-lab-nombre" readonly>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="font-weight-semibold" style="width: 120px;">Codigo</th>
                                    <th class="font-weight-semibold">Descripcion</th>
                                    <th class="font-weight-semibold">Composicion</th>
                                    <th class="font-weight-semibold" style="width: 140px;">Registro DNM</th>
                                    <th class="font-weight-semibold" style="width: 140px;">Stock minimo</th>
                                    <th class="font-weight-semibold">Presentacion</th>
                                    <th class="font-weight-semibold" style="width: 40px;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-variantes-nuevas"></tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer pt-0 border-top-0 justify-content-between">
                    <button type="button" class="btn btn-link" id="btnNuevasVariantesItem">+ Agregar variante</button>
                    <div>
                        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary font-weight-semibold">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para detalles -->
<div class="modal" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalDetallesLabel">Detalles medicamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registrar">
                <div class="modal-body pt-0">

                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <p class="text-muted mb-0">Id</p>
                            <p id="id-med"></p>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <p class="text-muted mb-0">Medicamento</p>
                            <p id="nombre-med"></p>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <p class="text-muted mb-0">Laboratorio</p>
                            <p id="laboratorio-med"></p>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <p class="text-muted mb-0">Categoria</p>
                            <p id="categoria-med"></p>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <p class="text-muted mb-0">Descripcion</p>
                            <p id="descripcion-med"></p>
                        </div>
                    </div>

                    <div class="mb-2">
                        <button type="button" class="btn btn-link px-0 font-weight-semibold" id="btnNuevasVariantes">&plus; Registrar variantes</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover">
                            <thead class="border-bottom" style="border-width: 2px !important;">
                                <tr>
                                    <th class="font-weight-semibold">#</th>
                                    <th class="font-weight-semibold">Codigo</th>
                                    <th class="font-weight-semibold">Descripcion</th>
                                    <th class="font-weight-semibold">Composicion</th>
                                    <th class="font-weight-semibold" style="width: 120px;">Registro DNM</th>
                                    <th class="font-weight-semibold" style="width: 120px;">Stock minimo</th>
                                    <th class="font-weight-semibold">Presentacion</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-variantes-med"></tbody>
                        </table>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para borrar medicamento -->
<div class="modal" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" style="width: 320px;">
        <div class="modal-content border-0 shadow-sm px-1">
            <div class="modal-header">
                <h5 class="modal-title font-weight-semibold" id="modalEliminarLabel">Eliminar medicamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-eliminar">
                <div class="modal-body">
                    <div class="text-center text-danger mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                    </div>
                    <h6 class="text-center">Deseas eliminar este elemento?</h6>
                    <input type="hidden" id="id-fel">
                </div>
                <div class="modal-footer border-top-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger font-weight-semibold">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    document.getElementById('medicamentos').classList.add('active')
</script>
<script>
    const stepper = new Stepper(document.querySelector('.bs-stepper'), {})

    async function listarMedicamentos() {
        const res = await http.get('/medicamentos')
        const {
            data
        } = res
        let html = ''

        data.map(i => html += `
            <tr>
                <td style="width: 80px;">${i.id}</td>
                <td>${i.nombre}</td>
                <td>${i.laboratorio.nombre}</td>
                <td>${i.categoria.nombre}</td>
                <td class="text-right" style="width: 80px;">
                    <div class="btn-group align-items-center">
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalDetalles" onclick="obtenerMedicamento(${i.id})">Detalles</button>
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalEliminar" onclick="obtenerMedicamentoParaEliminar(${i.id})">Borrar</button>
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

    async function listarLaboratorios() {
        const res = await http.get('/laboratorios')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.nombre}</option>
        `);

        document.getElementById('laboratorio-fr').innerHTML = html
    }

    async function listarCategorias() {
        const res = await http.get('/categorias')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.nombre}</option>
        `);

        document.getElementById('categoria-fr').innerHTML = html
    }

    async function listarPresentaciones() {
        const res = await http.get('/presentaciones')
        const {
            data
        } = res
        let html = '<option value="">Elegir opcion</option>'

        data.map(i => html += `
            <option value="${i.id}">${i.nombre}</option>
        `);

        return html;
    }

    async function obtenerMedicamento(id) {
        console.log(id);
        // return
        try {
            const res = await http.get(`/medicamentos/${id}`)
            const {
                data
            } = res
            let variantesHtml = ''

            data.variantes.forEach(i => variantesHtml += `
                <tr>
                    <td>${i.id}</td>
                    <td>${i.codigo}</td>
                    <td>${i.descripcion}</td>
                    <td>${i.composicion}</td>
                    <td>${i.registro_dnm}</td>
                    <td>${i.stock_min}</td>
                    <td>${i.presentacion.nombre}</td>
                </tr>
            `)

            console.log(data);

            document.getElementById('tbody-variantes-med').innerHTML = variantesHtml
            document.getElementById('id-med').innerText = data.id
            document.getElementById('nombre-med').innerText = data.nombre
            document.getElementById('laboratorio-med').innerText = data.laboratorio.nombre
            document.getElementById('categoria-med').innerText = data.categoria.nombre
            document.getElementById('descripcion-med').innerText = data.descripcion

            document.getElementById('nuevas-variantes-med-id').value = data.id
            document.getElementById('nuevas-variantes-med-nombre').value = data.nombre
            document.getElementById('nuevas-variantes-lab-nombre').value = data.laboratorio.nombre
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function registrarMedicamento(body) {
        try {
            const res = await http.post('/medicamentos', body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Registro completado!',
                text: "Medicamento registrado exitosamente"
            })
            listarMedicamentos()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerMedicamentoParaEliminar(id) {
        console.log(id);

        try {
            const res = await http.get(`/medicamentos/${id}`)
            const {
                data
            } = res

            document.getElementById('id-fel').value = data.id
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function eliminarMedicamento(id) {
        try {
            const res = await http.delete(`/medicamentos/${id}`)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Eliminacion completada!',
                text: "Medicamento eliminado exitosamente"
            })
            listarMedicamentos()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function registrarNuevasVariantes(body) {
        try {
            const res = await http.post('/medicamentos/variantes', body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Registro completado!',
                text: "Variante(s) registrada(s) exitosamente"
            })
            listarMedicamentos()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    function siguiente() {
        document.getElementById('modalDialogRegistrar').classList.add('modal-xl')
        stepper.next()
    }

    function anterior() {
        document.getElementById('modalDialogRegistrar').classList.remove('modal-xl')
        stepper.previous()
    }

    $(document).on('click', '.btnEliminarFila', function(e) {
        const elm = $(this).parent().parent().get(0)
        elm.remove()
    })

    document.getElementById("btnAgregarVariante").addEventListener("click", async function(e) {
        let newVariante = document.getElementById("new-variante")
        let newNode = newVariante.content.cloneNode(true)
        newNode.querySelector("select").innerHTML = await listarPresentaciones()
        document.getElementById("tbody-variantes").appendChild(newNode)
    })

    document.getElementById('form-registrar').addEventListener('submit', async function(e) {
        e.preventDefault()

        console.log('enviando formulario')
        const nombre = document.getElementById("nombre-fr").value
        const laboratorio = document.getElementById("laboratorio-fr").value
        const categoria = document.getElementById("categoria-fr").value
        const descripcion = document.getElementById("descripcion-fr").value
        const listaVariantes = document.getElementById("tbody-variantes")

        if (listaVariantes.children.length == 0) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Debes llenar almenos una variante"
            })
            return
        }

        let variantes = []
        let codigo = ""
        let descripcionVariante = ""
        let composicion = ""
        let registroDnm = ""
        let presentacion = ""

        for (let i of listaVariantes.children) {

            codigo = i.querySelector(".codigo").value
            descripcionVariante = i.querySelector(".descripcion").value
            composicion = i.querySelector(".composicion").value
            registroDnm = i.querySelector(".registro_dnm").value
            stockMin = i.querySelector(".stock_min").value
            presentacion = i.querySelector(".presentacion").value

            variantes.push({
                codigo,
                descripcion: descripcionVariante,
                composicion,
                registroDnm,
                stockMin,
                presentacion
            })
        }

        let obj = {
            nombre,
            laboratorio_id: laboratorio,
            categoria_id: categoria,
            descripcion,
            presentaciones: variantes
        }

        await registrarMedicamento(obj)
        document.getElementById("nombre-fr").value = ""
        document.getElementById("laboratorio-fr").value = ""
        document.getElementById("categoria-fr").value = ""
        document.getElementById("descripcion-fr").value = ""
        document.getElementById("tbody-variantes").innerHTML = ""
        document.getElementById('modalDialogRegistrar').classList.remove('modal-xl')
        stepper.to(0)
        $('#modalRegistrar').modal('hide')
    })

    document.getElementById('form-eliminar').addEventListener('submit', async function(e) {
        e.preventDefault()

        // id-form-eliminar
        const id = document.getElementById("id-fel").value

        await eliminarMedicamento(id)
        document.getElementById("id-fel").value = ""
        $('#modalEliminar').modal('hide')
    })

    document.getElementById('btnNuevasVariantes').addEventListener('click', function(e) {
        $('#modalDetalles').modal('hide')
        $('#modalNuevasVariantes').modal('show')
    })

    document.getElementById("btnNuevasVariantesItem").addEventListener("click", async function(e) {
        let newVariante = document.getElementById("new-variante")
        let newNode = newVariante.content.cloneNode(true)
        newNode.querySelector("select").innerHTML = await listarPresentaciones()
        document.getElementById("tbody-variantes-nuevas").appendChild(newNode)
    })

    document.getElementById('form-nuevas-variantes').addEventListener('submit', async function(e) {
        e.preventDefault()

        console.log('enviando formulario')
        const medicamentoId = document.getElementById("nuevas-variantes-med-id").value
        const listaVariantes = document.getElementById("tbody-variantes-nuevas")

        if (listaVariantes.children.length == 0) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Debes llenar almenos una variante"
            })
            return
        }

        let variantes = []
        let codigo = ""
        let descripcionVariante = ""
        let composicion = ""
        let registroDnm = ""
        let presentacion = ""

        for (let i of listaVariantes.children) {

            codigo = i.querySelector(".codigo").value
            descripcionVariante = i.querySelector(".descripcion").value
            composicion = i.querySelector(".composicion").value
            registroDnm = i.querySelector(".registro_dnm").value
            stockMin = i.querySelector(".stock_min").value
            presentacion = i.querySelector(".presentacion").value

            variantes.push({
                codigo,
                descripcion: descripcionVariante,
                composicion,
                registroDnm,
                stockMin,
                presentacion
            })
        }

        let obj = {
            medicamento_id: medicamentoId,
            presentaciones: variantes
        }

        await registrarNuevasVariantes(obj)
        document.getElementById('nuevas-variantes-med-id').value = ""
        document.getElementById('nuevas-variantes-med-nombre').value = ""
        document.getElementById('nuevas-variantes-lab-nombre').value = ""
        document.getElementById("tbody-variantes-nuevas").innerHTML = ""
        $('#modalNuevasVariantes').modal('hide')
    })

    listarMedicamentos()
    listarLaboratorios()
    listarCategorias()
</script>
@endpush

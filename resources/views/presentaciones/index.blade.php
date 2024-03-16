@extends('shared.index')

@section('content')
<div style="max-width: 820px;">
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <a href="/dashboard">
                    <i class="fas fa-chevron-left"></i>
                    <span class="ml-1">Volver</span>
                </a>
                <h5 class="font-weight-semibold">Presentaciones</h5>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-light font-weight-semibold" data-toggle="modal" data-target="#modalRegistrar">
                    Nueva presentacion
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-hover dt-table">
            <thead>
                <tr>
                    <th class="font-weight-semibold">#</th>
                    <th class="font-weight-semibold">Presentacion</th>
                    <th class="font-weight-semibold">Descripcion</th>
                    <th class="font-weight-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>
</div>

<!-- modal para registrar categoria -->
<div class="modal" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalRegistrarLabel">Nueva presentacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registrar">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre-fr" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Descripcion</label>
                        <textarea class="form-control" id="descripcion-fr" rows="4"></textarea>
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

<!-- modal para editar categoria -->
<div class="modal" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalEditarLabel">Editar presentacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-editar">
                <div class="modal-body">
                    <input type="hidden" id="id-fed">
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre-fed" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Descripcion</label>
                        <textarea class="form-control" id="descripcion-fed" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary font-weight-semibold">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para borrar categoria -->
<div class="modal" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" style="width: 320px;">
        <div class="modal-content border-0 shadow-sm px-1">
            <div class="modal-header">
                <h5 class="modal-title font-weight-semibold" id="modalEliminarLabel">Eliminar presentacion</h5>
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
<script>
    document.getElementById('presentaciones').classList.add('active')
</script>
<script>
    async function listarPresentaciones() {
        const res = await http.get('/presentaciones')
        const {
            data
        } = res
        let html = ''

        data.map(i => html += `
            <tr>
                <td style="width: 80px;">${i.id}</td>
                <td>${i.nombre}</td>
                <td>${i.descripcion ?? '-'}</td>
                <td class="text-right" style="width: 80px;">
                    <div class="btn-group align-items-center">
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalEditar" onClick="obtenerPresentacionParaEditar(${i.id})">Editar</button>
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalEliminar" onClick="obtenerPresentacionParaEliminar(${i.id})">Borrar</button>
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

    async function registrarPresentacion(body) {
        try {
            const res = await http.post('/presentaciones', body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Registro completado!',
                text: "Presentacion registrada exitosamente"
            })
            listarPresentaciones()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function editarPresentacion(body) {
        try {
            const res = await http.put(`/presentaciones/${body.id}`, body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Actualizacion completada!',
                text: "Presentacion actuzalizada exitosamente"
            })
            listarPresentaciones()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerPresentacionParaEditar(id) {
        console.log(id);

        try {
            const res = await http.get(`/presentaciones/${id}`)
            const {
                data
            } = res

            document.getElementById('id-fed').value = data.id
            document.getElementById('nombre-fed').value = data.nombre
            document.getElementById('descripcion-fed').value = data.descripcion
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerPresentacionParaEliminar(id) {
        console.log(id);

        try {
            const res = await http.get(`/presentaciones/${id}`)
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

    async function eliminarPresentacion(id) {
        try {
            const res = await http.delete(`/presentaciones/${id}`)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Eliminacion completada!',
                text: "Presentacion eliminada exitosamente"
            })
            listarPresentaciones()
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

        // nombre-form-registrar
        const nombre = document.getElementById("nombre-fr").value
        const descripcion = document.getElementById("descripcion-fr").value
        const body = {
            nombre,
            descripcion
        }

        await registrarPresentacion(body)
        document.getElementById("nombre-fr").value = ""
        $('#modalRegistrar').modal('hide')
    })

    document.getElementById('form-editar').addEventListener('submit', async function(e) {
        e.preventDefault()

        const id = document.getElementById("id-fed").value // id-form-editar
        const nombre = document.getElementById("nombre-fed").value // nombre-form-editar
        const descripcion = document.getElementById("descripcion-fed").value // nombre-form-editar
        const body = {
            id,
            nombre,
            descripcion
        }

        await editarPresentacion(body)
        document.getElementById("id-fed").value = ""
        document.getElementById("nombre-fed").value = ""
        document.getElementById("descripcion-fed").value = ""
        $('#modalEditar').modal('hide')
    })

    document.getElementById('form-eliminar').addEventListener('submit', async function(e) {
        e.preventDefault()

        // id-form-eliminar
        const id = document.getElementById("id-fel").value

        await eliminarPresentacion(id)
        document.getElementById("id-fel").value = ""
        $('#modalEliminar').modal('hide')
    })

    listarPresentaciones()
</script>
@endpush

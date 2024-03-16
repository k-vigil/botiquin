@extends('shared.index')

@section('content')
<div style="max-width: 920px;">
    <div class="mb-3">
        <div class="row">
            <div class="col-6">
                <a href="/dashboard">
                    <i class="fas fa-chevron-left"></i>
                    <span class="ml-1">Volver</span>
                </a>
                <h5 class="font-weight-semibold">Lotes</h5>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-light font-weight-semibold" data-toggle="modal" data-target="#modalRegistrar">
                    Nuevo lote
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-hover dt-table">
            <thead>
                <tr>
                    <th class="font-weight-semibold">#</th>
                    <th class="font-weight-semibold">Codigo</th>
                    <th class="font-weight-semibold">Fabricacion</th>
                    <th class="font-weight-semibold">Vencimiento</th>
                    <th class="font-weight-semibold">Descripcion</th>
                    <th class="font-weight-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>
</div>

<!-- modal para registrar lote -->
<div class="modal" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalRegistrarLabel">Nuevo lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-registrar">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Codigo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo-fr" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Fabricacion <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fabricacion-fr" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Vencimiento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="vencimiento-fr" required>
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

<!-- modal para editar lote -->
<div class="modal" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-light shadow-sm">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-semibold" id="modalEditarLabel">Editar lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-editar">
                <div class="modal-body">
                    <input type="hidden" id="id-fed">
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Codigo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo-fed" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Fabricacion <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fabricacion-fed" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-semibold">Vencimiento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="vencimiento-fed" required>
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

<!-- modal para borrar lote -->
<div class="modal" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" style="width: 320px;">
        <div class="modal-content border-0 shadow-sm px-1">
            <div class="modal-header">
                <h5 class="modal-title font-weight-semibold" id="modalEliminarLabel">Eliminar lote</h5>
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
    document.getElementById('lotes').classList.add('active')
</script>
<script>
    async function listarLotes() {
        const res = await http.get('/lotes')
        const {
            data
        } = res
        let html = ''

        data.map(i => html += `
            <tr>
                <td style="width: 80px;">${i.id}</td>
                <td>${i.codigo}</td>
                <td>${i.fabricacion}</td>
                <td>${i.vencimiento}</td>
                <td>${i.descripcion ?? '-'}</td>
                <td class="text-right" style="width: 80px;">
                    <div class="btn-group align-items-center">
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalEditar" onClick="obtenerLoteParaEditar(${i.id})">Editar</button>
                        <button type="button" class="btn btn-link px-1 py-0" data-toggle="modal" data-target="#modalEliminar" onClick="obtenerLoteParaEliminar(${i.id})">Borrar</button>
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

    async function registrarLote(body) {
        try {
            const res = await http.post('/lotes', body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Registro completado!',
                text: "Lote registrado exitosamente"
            })
            listarLotes()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function editarLote(body) {
        try {
            const res = await http.put(`/lotes/${body.id}`, body)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Actualizacion completada!',
                text: "Lote actuzalizado exitosamente"
            })
            listarLotes()
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerLoteParaEditar(id) {
        console.log(id);

        try {
            const res = await http.get(`/lotes/${id}`)
            const {
                data
            } = res

            document.getElementById('id-fed').value = data.id
            document.getElementById('codigo-fed').value = data.codigo
            document.getElementById('fabricacion-fed').value = data.fabricacion
            document.getElementById('vencimiento-fed').value = data.vencimiento
            document.getElementById('descripcion-fed').value = data.descripcion
        } catch (err) {
            Toast.fire({
                icon: 'error',
                title: 'Ops!',
                text: "Algo salio mal. Intenta en un momento"
            })
        }
    }

    async function obtenerLoteParaEliminar(id) {
        console.log(id);

        try {
            const res = await http.get(`/lotes/${id}`)
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

    async function eliminarLote(id) {
        try {
            const res = await http.delete(`/lotes/${id}`)
            const {
                data
            } = res

            Toast.fire({
                icon: 'success',
                title: 'Eliminacion completada!',
                text: "Lote eliminado exitosamente"
            })
            listarLotes()
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
        const codigo = document.getElementById("codigo-fr").value
        const fabricacion = document.getElementById("fabricacion-fr").value
        const vencimiento = document.getElementById("vencimiento-fr").value
        const descripcion = document.getElementById("descripcion-fr").value
        const body = {
            codigo,
            fabricacion,
            vencimiento,
            descripcion
        }

        await registrarLote(body)
        document.getElementById("codigo-fr").value = ""
        document.getElementById("fabricacion-fr").value = ""
        document.getElementById("vencimiento-fr").value = ""
        document.getElementById("descripcion-fr").value = ""
        $('#modalRegistrar').modal('hide')
    })

    document.getElementById('form-editar').addEventListener('submit', async function(e) {
        e.preventDefault()

        const id = document.getElementById("id-fed").value // id-form-editar
        const codigo = document.getElementById("codigo-fed").value
        const fabricacion = document.getElementById("fabricacion-fed").value
        const vencimiento = document.getElementById("vencimiento-fed").value
        const descripcion = document.getElementById("descripcion-fed").value
        const body = {
            id,
            codigo,
            fabricacion,
            vencimiento,
            descripcion
        }

        await editarLote(body)
        document.getElementById("id-fed").value = ""
        document.getElementById("codigo-fed").value = ""
        document.getElementById("fabricacion-fed").value = ""
        document.getElementById("vencimiento-fed").value = ""
        document.getElementById("descripcion-fed").value = ""
        $('#modalEditar').modal('hide')
    })

    document.getElementById('form-eliminar').addEventListener('submit', async function(e) {
        e.preventDefault()

        // id-form-eliminar
        const id = document.getElementById("id-fel").value

        await eliminarLote(id)
        document.getElementById("id-fel").value = ""
        $('#modalEliminar').modal('hide')
    })

    listarLotes()
</script>
@endpush

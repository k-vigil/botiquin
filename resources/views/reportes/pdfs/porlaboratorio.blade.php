<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex</title>
    <link rel="stylesheet" href="{{ public_path('dist/css/adminlte.min.css') }}">
    <style>
        @font-face {
            font-family: "Roboto Mono";
            src: url("{{ public_path('fonts/RobotoMono-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "Roboto Mono SemiBold";
            src: url("{{ public_path('fonts/RobotoMono-SemiBold.ttf') }}") format("truetype");
            font-weight: 600;
            font-style: normal;
        }

        html {
            font-size: 9px;
        }

        .fw-semibold {
            font-family: 'Roboto Mono SemiBold';
            font-weight: 600;
        }

        .fw-regular {
            font-family: 'Roboto Mono';
            font-weight: normal;
        }
    </style>
</head>

<body>
    <h5 class="fw-semibold text-uppercase">Medicamentos por laboratorio</h5>
    <h6 class="text-uppercase"><span class="fw-semibold">Laboratorio:</span>&nbsp;<span class="fw-regular">{{ $laboratorio }}</span></h6>
    <br>
    <table class="table table-borderless">
        <thead class="border-bottom">
            <tr>
                <th class="fw-semibold text-uppercase py-1">N°</th>
                <th class="fw-semibold text-uppercase py-1">Laboratorio</th>
                <th class="fw-semibold text-uppercase py-1">Codigo</th>
                <th class="fw-semibold text-uppercase py-1">Medicamento</th>
                <th class="fw-semibold text-uppercase py-1">R.S.</th>
                <th class="fw-semibold text-uppercase py-1">Pres.</th>
                <th class="fw-semibold text-uppercase py-1 text-right">Cant.</th>
                <th class="fw-semibold text-uppercase py-1">Precio</th>
                <th class="fw-semibold text-uppercase py-1">Lote</th>
                <th class="fw-semibold text-uppercase py-1">vto.</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) > 0)
            @php $index = 1 @endphp
            @foreach ($data as $i)
            <tr>
                <td class="fw-regular text-uppercase py-1">{{ $index++ }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->lab }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->codigo }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->descripcion }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->registro_dnm }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->pres }}</td>
                <td class="fw-regular text-uppercase py-1 text-right">{{ $i->cantidad }}</td>
                <td class="fw-regular text-uppercase py-1">${{ number_format($i->precio, 2) }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->lote }}</td>
                <td class="fw-regular text-uppercase py-1">{{ $i->vencimiento }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">No hay datos</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>

</html>

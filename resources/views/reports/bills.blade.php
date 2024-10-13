<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Contas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .table-header {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .table-row:nth-child(even) {
            background-color: #f9fafb;
        }

        .table-row:hover {
            background-color: #f1f5f9;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>

<body class="bg-white p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Relatório de Contas</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="table-header">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Data de Vencimento</th>
                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Valor</th>
                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Usuário</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($bills as $bill)
                    <tr class="table-row">
                        <td class="py-4 px-6">{{ $bill->id }}</td>
                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}</td>
                        <td class="py-4 px-6">{{ number_format($bill->amount, 2, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bill->status == 'paid' ? 'status-paid' : 'status-pending' }}">
                                {{ $bill->status == 'paid' ? 'Pago' : 'Pendente' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">{{ $bill->user->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

<!DOCTYPE html>
<html>
<head>
    <title>Diagram Stok Masuk</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            function validateDates() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate) {
                    if (endDate < startDate) {
                        endDateInput.setCustomValidity('Tanggal akhir tidak boleh lebih kecil dari tanggal mulai.');
                    } else if ((endDate - startDate) > (7 * 24 * 60 * 60 * 1000)) { // 7 hari dalam milidetik
                        endDateInput.setCustomValidity('Rentang tanggal tidak boleh lebih dari 7 hari.');
                    } else {
                        endDateInput.setCustomValidity('');
                    }
                }
            }

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);
        });
    </script>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Riwayat Kegiatan
        </h2>
    </x-slot>

    <style>
        th {
            font-size: 20px; 
            padding: 0 0 20px 0; 
            text-align:center;
        }

        td {
            width: 50%; 
            padding: 30px;
        }

        .bg-slate {
            background-color: rgb(165 27 27);
            padding: 20px 50px;
        }

        .icon {
            font-size: 35px;
        }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card style="padding: 50px;"> 

                <form method="GET" action="{{ url('/diagram_kegiatan_pegawai') }}">
                    <div class="flex items-center w-1/2 mt-2">
                        <x-inputs.basic 
                            type="date" 
                            id="start_date" 
                            :name="'start_date'" 
                            :value="$start_date ?? ''">
                        </x-inputs.basic> &nbsp;&nbsp;&nbsp;-
                        <x-inputs.basic 
                            style="margin: 0 10px;"
                            type="date" 
                            id="end_date" 
                            :name="'end_date'" 
                            :value="$end_date ?? ''">
                        </x-inputs.basic>

                        <button type="submit" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                            Filter
                        </button>
                    </div>
                </form>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-8 mt-8">
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-sack-dollar"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Total kegiatan dari {{ $start_date }} sampai {{ $end_date }}</h5>
                            <div class="text-2xl font-semibold">{{ $total_kegiatan }}</div>
                        </div>
                    </div>
                </div>

                <table style="width: 100%;">
                    <tr>
                        <th>Chart Kegiatan</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                {!! $kegiatan->container() !!}
                            </div>
                            
                            <script src="{{ $kegiatan->cdn() }}"></script>
                            
                            {{ $kegiatan->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>
</body>
</html>

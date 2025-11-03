<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Riwayat Pelamar
        </h2>
    </x-slot>

    <style>
        th {
            font-size: 20px; 
            padding: 0 0 20px 0; 
            text-align: center;
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

        /* Mobile-specific layout fixes for diagram (only affects <=768px) */
        @media (max-width: 768px) {
            .py-12.min-h-screen {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            .max-w-7xl.mx-auto.sm\:px-6.lg\:px-8 {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            .bg-slate {
                padding: 15px 20px !important;
            }

            th {
                font-size: 16px !important;
                padding: 20px 0 !important;
            }

            td {
                width: 100% !important;
                padding: 15px !important;
            }

            .icon {
                font-size: 28px !important;
            }

            .grid.grid-cols-1.md\:grid-cols-2 {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }

            table {
                display: block !important;
                width: 100% !important;
            }

            table tr {
                display: block !important;
            }

            table th,
            table td {
                display: block !important;
            }
        }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card style="padding: 50px;"> 
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Pelamar Diterima</h5>
                            <div class="text-2xl font-semibold">{{ $pelamar_diterima }}</div>
                        </div>
                    </div>
    
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-user-xmark"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Pelamar Ditolak</h5>
                            <div class="text-2xl font-semibold">{{ $pelamar_ditolak }}</div>
                        </div>
                    </div>
                </div>

                <table style="width: 100%;">
                    <tr>
                        <th style="padding-top: 50px;">Chart WSM (Weighted Sum Model) Pelamar</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                {!! $wsm->container() !!}
                            </div>
                            
                            <script src="{{ $wsm->cdn() }}"></script>
                            
                            {{ $wsm->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>

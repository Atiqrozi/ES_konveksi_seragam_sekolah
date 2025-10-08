<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Pegawai
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
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card style="padding: 50px;"> 
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Total Pegawai</h5>
                            <div class="text-2xl font-semibold">{{ $total_pegawai }}</div>
                        </div>
                    </div>
    
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Pegawai Laki-Laki</h5>
                            <div class="text-2xl font-semibold">{{ $pegawai_laki }}</div>
                        </div>
                    </div>
    
                    <div class="bg-slate p-6 rounded shadow flex items-center justify-between text-white">
                        <div class="icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg">Pegawai Perempuan</h5>
                            <div class="text-2xl font-semibold">{{ $pegawai_perempuan }}</div>
                        </div>
                    </div>
                </div>
                
                <table style="width: 100%;">
                    <tr>
                        <th style="padding-top: 50px;">Chart Jenis Kelamin</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                {!! $jk->container() !!}
                            </div>
                            
                            <script src="{{ $jk->cdn() }}"></script>
                            
                            {{ $jk->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>

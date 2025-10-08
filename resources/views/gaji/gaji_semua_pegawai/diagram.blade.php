<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Gaji Pegawai
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
                <table style="width: 100%;">
                    <tr>
                        <th>Chart Gaji Pegawai</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                {!! $gaji->container() !!}
                            </div>
                            
                            <script src="{{ $gaji->cdn() }}"></script>
                            
                            {{ $gaji->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>
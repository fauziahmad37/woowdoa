@extends('layouts.app')

@section('content')
<div class="py-6">
      <div class="container mx-auto w-full px-4">

        <!-- Breadcrumb -->
        <!-- <nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="list-reset flex flex-wrap items-center">
                <li class="flex items-center">
                    <a href="{{ route('jenis_asuransi.index') }}" class="text-orange-600 hover:text-blue-800">Jenis Asuransi</a>
                    <span class="mx-2 flex-shrink-0">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646447 0.646447C0.841709 0.451184 1.15829 0.451184 1.35355 0.646447L7.35355 6.64645C7.54882 6.84171 7.54882 7.15829 7.35355 7.35355L1.35355 13.3536C1.15829 13.5488 0.841709 13.5488 0.646447 13.3536C0.451184 13.1583 0.451184 12.8417 0.646447 12.6464L6.29289 7L0.646447 1.35355C0.451184 1.15829 0.451184 0.841709 0.646447 0.646447Z" fill="#1A2130"/>
                        </svg>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-500">Daftar Jenis Asuransi</span>
                </li>
            </ol>
        </nav> -->

        <!-- Header -->
  <h2 class="text-xl font-semibold text-gray-600">Daftar Jenis Asuransi</h2>
             <p class="text-gray-500 mb-10">Pendataan Jenis Asuransi</p>
       <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
    <form method="GET" action="{{ route('jenis_asuransi.index') }}" 
          class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
        <input id="searchInput" type="text" name="search" placeholder="Cari Jenis Asuransi"
               value="{{ request('search') }}"
               class="w-full sm:w-auto border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button id="searchBtn" type="submit"
                class="w-full sm:w-auto bg-gray-200 text-gray-700 px-4 py-2 rounded-md cursor-not-allowed"
                disabled>
            Cari
        </button>

        <a href="{{ route('jenis_asuransi.index') }}"
           class="w-full sm:w-auto text-center text-white px-4 py-2 rounded-md"
           style="color:#FF6200;border:1px solid #FF6200;">
            Atur Ulang
        </a>
    </form>

    <a href="{{ route('jenis_asuransi.create') }}"
       class="px-4 py-2 rounded-lg text-white w-full sm:w-auto text-center"
       style="background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);">
        + Tambah Jenis Asuransi
    </a>
</div>

        <!-- Table -->
        <div class="w-full max-w-full overflow-x-auto intro-y overflow-auto lg:overflow-visible " >
          
                {{-- Info pencarian --}}
@if(request('search'))
    <p class="mb-4 text-sm text-gray-600">
        Menampilkan hasil pencarian 
        <span class="font-semibold">“{{ request('search') }}”</span> :
        {{ $jenis_asuransi->count() }} Data ditampilkan
    </p>
@endif

{{-- Hasil data --}}
@if($jenis_asuransi->count() > 0) 
 <div class="w-full overflow-x-auto">
        <table id="jenis_asuransiTable" 
                   class="min-w-full mt-4  bg-white  border border-gray-200 divide-y divide-gray-200 table-auto">
                <thead class="">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border">Nama Jenis Asuransi</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 border">Aksi</th>
                       
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($jenis_asuransi as $i => $item)
                        <tr class="border-b hover:bg-gray-50">
                             <td>{{ $jenis_asuransi->firstItem() + $i }}</td>
                            <td>{{ $item->jenis_asuransi_nama }}</td>

   <td class="px-4 py-3 text-center">
    <div class="flex justify-center">
        <details class="relative inline-block text-left dropdown">
              <summary
                class="list-none bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 cursor-pointer marker:content-none tombol-action">
              <svg width="13" height="4" viewBox="0 0 13 4" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.83333 0.666016C1.1 0.666016 0.5 1.26602 0.5 1.99935C0.5 2.73268 1.1 3.33268 1.83333 3.33268C2.56667 3.33268 3.16667 2.73268 3.16667 1.99935C3.16667 1.26602 2.56667 0.666016 1.83333 0.666016ZM11.1667 0.666016C10.4333 0.666016 9.83333 1.26602 9.83333 1.99935C9.83333 2.73268 10.4333 3.33268 11.1667 3.33268C11.9 3.33268 12.5 2.73268 12.5 1.99935C12.5 1.26602 11.9 0.666016 11.1667 0.666016ZM6.5 0.666016C5.76667 0.666016 5.16667 1.26602 5.16667 1.99935C5.16667 2.73268 5.76667 3.33268 6.5 3.33268C7.23333 3.33268 7.83333 2.73268 7.83333 1.99935C7.83333 1.26602 7.23333 0.666016 6.5 0.666016Z" fill="white"/>
</svg>

            </summary>
            <div
                class="absolute top-0 right-0 mt-2 w-48 sm:w-64 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                <a href="{{ route('jenis_asuransi.edit', $item->jenis_asuransi_id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                     <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.4265 0.573977C11.0866 0.234575 10.6259 0.0439453 10.1455 0.0439453C9.66515 0.0439453 9.20443 0.234575 8.86451 0.573977L0.732508 8.70598C0.499633 8.93754 0.314989 9.21299 0.189257 9.51637C0.0635245 9.81976 -0.000798988 10.1451 7.49061e-06 10.4735V11.5C7.49061e-06 11.6326 0.0526859 11.7598 0.146454 11.8535C0.240222 11.9473 0.367399 12 0.500008 12H1.52651C1.85489 12.0009 2.18019 11.9367 2.48359 11.811C2.78698 11.6854 3.06243 11.5008 3.29401 11.268L11.4265 3.13548C11.7658 2.79557 11.9563 2.33496 11.9563 1.85473C11.9563 1.37449 11.7658 0.913879 11.4265 0.573977ZM2.58701 10.561C2.30501 10.8411 1.92399 10.9988 1.52651 11H1.00001V10.4735C0.999502 10.2764 1.03809 10.0812 1.11353 9.8992C1.18897 9.71717 1.29976 9.5519 1.43951 9.41298L7.61101 3.24148L8.76101 4.39148L2.58701 10.561ZM10.719 2.42848L9.46601 3.68198L8.31601 2.53448L9.56951 1.28098C9.64502 1.20563 9.73463 1.1459 9.83322 1.10518C9.93182 1.06447 10.0375 1.04357 10.1441 1.04369C10.2508 1.0438 10.3564 1.06493 10.4549 1.10586C10.5534 1.14679 10.6429 1.20672 10.7183 1.28223C10.7936 1.35774 10.8533 1.44735 10.8941 1.54594C10.9348 1.64454 10.9557 1.75019 10.9555 1.85686C10.9554 1.96353 10.9343 2.06914 10.8934 2.16764C10.8524 2.26615 10.7925 2.35563 10.717 2.43098L10.719 2.42848Z" fill="#1A2130"/>
</svg>
 Ubah Data
                </a>
                <button type="button" onclick="openDeleteModal({{ $item->jenis_asuransi_id }})"
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.5 2H8.95C8.83395 1.43571 8.52691 0.928673 8.08063 0.564359C7.63434 0.200045 7.0761 0.000727262 6.5 0L5.5 0C4.9239 0.000727262 4.36566 0.200045 3.91937 0.564359C3.47309 0.928673 3.16605 1.43571 3.05 2H1.5C1.36739 2 1.24021 2.05268 1.14645 2.14645C1.05268 2.24021 1 2.36739 1 2.5C1 2.63261 1.05268 2.75979 1.14645 2.85355C1.24021 2.94732 1.36739 3 1.5 3H2V9.5C2.00079 10.1628 2.26444 10.7982 2.73311 11.2669C3.20178 11.7356 3.8372 11.9992 4.5 12H7.5C8.1628 11.9992 8.79822 11.7356 9.26689 11.2669C9.73556 10.7982 9.99921 10.1628 10 9.5V3H10.5C10.6326 3 10.7598 2.94732 10.8536 2.85355C10.9473 2.75979 11 2.63261 11 2.5C11 2.36739 10.9473 2.24021 10.8536 2.14645C10.7598 2.05268 10.6326 2 10.5 2ZM5.5 1H6.5C6.81014 1.00038 7.11256 1.09669 7.36581 1.27572C7.61905 1.45476 7.81071 1.70775 7.9145 2H4.0855C4.18929 1.70775 4.38095 1.45476 4.63419 1.27572C4.88744 1.09669 5.18986 1.00038 5.5 1ZM9 9.5C9 9.89782 8.84196 10.2794 8.56066 10.5607C8.27936 10.842 7.89782 11 7.5 11H4.5C4.10218 11 3.72064 10.842 3.43934 10.5607C3.15804 10.2794 3 9.89782 3 9.5V3H9V9.5Z" fill="#EB5757"/>
<path d="M5 8.99999C5.13261 8.99999 5.25978 8.94731 5.35355 8.85355C5.44732 8.75978 5.5 8.6326 5.5 8.49999V5.5C5.5 5.36739 5.44732 5.24021 5.35355 5.14645C5.25978 5.05268 5.13261 5 5 5C4.86739 5 4.74021 5.05268 4.64645 5.14645C4.55268 5.24021 4.5 5.36739 4.5 5.5V8.49999C4.5 8.6326 4.55268 8.75978 4.64645 8.85355C4.74021 8.94731 4.86739 8.99999 5 8.99999Z" fill="#EB5757"/>
<path d="M7 8.99999C7.13261 8.99999 7.25979 8.94731 7.35356 8.85355C7.44733 8.75978 7.50001 8.6326 7.50001 8.49999V5.5C7.50001 5.36739 7.44733 5.24021 7.35356 5.14645C7.25979 5.05268 7.13261 5 7 5C6.86739 5 6.74022 5.05268 6.64645 5.14645C6.55268 5.24021 6.5 5.36739 6.5 5.5V8.49999C6.5 8.6326 6.55268 8.75978 6.64645 8.85355C6.74022 8.94731 6.86739 8.99999 7 8.99999Z" fill="#EB5757"/>
</svg>
  Hapus Data
                </button>
            </div>
        </details>
    </div>
</td>

                         
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">
                                Belum ada data jenis_asuransi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
    {{ $jenis_asuransi->links() }}
</div>

            </div>
                  @else
                  
    </div>
    <div class="text-center py-6">
        <img src="{{ asset('images/no-data.png') }}" alt="Tidak ada data" class="mx-auto w-64 mb-4">
       
    </div>
@endif
        </div>

    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-gray-800 bg-opacity-40" onclick="closeDeleteModal()"></div>

    <div id="deleteModalContent"
         class="relative bg-white rounded-xl shadow-lg p-6 max-w-md w-full transform scale-95 opacity-0 transition-all duration-200">
<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="24" fill="#FDE2D3"/>
<path d="M29 16H34V18H32V33C32 33.5523 31.5523 34 31 34H17C16.4477 34 16 33.5523 16 33V18H14V16H19V14H29V16ZM21 21V29H23V21H21ZM25 21V29H27V21H25Z" fill="url(#paint0_linear_714_10747)"/>
<defs>
<linearGradient id="paint0_linear_714_10747" x1="26.1111" y1="14" x2="18.5" y2="31.7778" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
</defs>
</svg>


        <h2 class="text-lg font-semibold text-gray-800">
            Apakah Anda yakin ingin menghapus data ini?
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Data yang dihapus tidak dapat dipulihkan kembali.
        </p>

        <div class="mt-6 flex justify-center gap-3">
            <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 button-cancel"
                    >
                Batalkan
            </button>

            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 text-white rounded-lg button-add"
                    >
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
$('#jenis_asuransiTable').DataTable({
    responsive: true,
    autoWidth: false,
    paging: false,   
    searching: false,
    ordering: true,
    info: false,  
     order: [[1, 'asc']]    
});


    // Dropdown agar hanya satu yang terbuka
    const details = document.querySelectorAll("details");
    details.forEach((targetDetail) => {
        targetDetail.addEventListener("toggle", () => {
            if (targetDetail.open) {
                details.forEach((detail) => {
                    if (detail !== targetDetail) {
                        detail.removeAttribute("open");
                    }
                });
            }
        });
    });
});

// Modal Delete
function openDeleteModal(jenis_asuransiId) {
    let modal = document.getElementById('deleteModal');
    let content = document.getElementById('deleteModalContent');
    let form = document.getElementById('deleteForm');

    form.action = '/jenis_asuransi/' + jenis_asuransiId;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 50);
}

function closeDeleteModal() {
    let modal = document.getElementById('deleteModal');
    let content = document.getElementById('deleteModalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}


// dropdown

document.querySelectorAll("details.dropdown").forEach((el) => {
    el.addEventListener("toggle", function () {
        if (this.open) {
            document.querySelectorAll("details.dropdown").forEach((other) => {
                if (other !== this) other.removeAttribute("open");
            });
        }
    });
});

  // Search button enable/disable
    function toggleSearchButton() {
        const searchInput = document.getElementById("searchInput").value.trim();
        const searchBtn = document.getElementById("searchBtn");

        if (searchInput !== "") {
            searchBtn.disabled = false;
            searchBtn.classList.remove("bg-gray-200", "text-gray-700", "cursor-not-allowed");
            searchBtn.classList.add("bg-orange-500", "hover:bg-orange-600", "text-white");
        } else {
            searchBtn.disabled = true;
            searchBtn.classList.add("bg-gray-200", "text-gray-700", "cursor-not-allowed");
            searchBtn.classList.remove("bg-orange-500", "hover:bg-orange-600", "text-white");
        }
    }

    toggleSearchButton();
    document.getElementById("searchInput").addEventListener("input", toggleSearchButton);


</script>
@endpush

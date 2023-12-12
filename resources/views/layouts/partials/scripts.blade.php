@vite(['resources/js/app.js'])

<script src="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('/vendors/tinymce/tinymce.min.js') }}"></script>


<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
{{-- Jquery --}}
<script src="{{ asset('/js/extensions/jquery/jquery.min.js') }}"></script>

{{-- Sweet Alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Datatable --}}
<script src="{{ asset('/js/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

{{-- Icon fontawesome --}}
<script src="https://kit.fontawesome.com/9d17737383.js" crossorigin="anonymous"></script>
{{-- Apexcharts --}}
<script src="{{ asset('/js/extensions/apexcharts/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('/js/pages/dashboard.js') }}"></script> --}}

{{-- Pdf Exporter --}}
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>


<!-- Excel Exporter -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

@livewireScripts
<script src="{{ asset('/js/main.js') }}"></script>

{{ $script ?? '' }}

@vite(['resources/js/app.js'])

<script src="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('/vendors/tinymce/tinymce.min.js') }}"></script>


<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
{{-- Jquery --}}
<script src="{{ asset('/js/extensions/jquery/jquery.min.js') }}"></script>

{{-- Datatable --}}
<script src="{{ asset('/js/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/js/extensions/datatables.net-bs5/datatables.js') }}"></script>



{{-- Apexcharts --}}
<script src="{{ asset('/js/extensions/apexcharts/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('/js/pages/dashboard.js') }}"></script> --}}

@livewireScripts
<script src="{{ asset('/js/main.js') }}"></script>

{{ $script ?? '' }}

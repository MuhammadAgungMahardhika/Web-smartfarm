@vite(['resources/js/app.js'])

<script src="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('/vendors/tinymce/tinymce.min.js') }}"></script>


<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
{{-- Jquery --}}
<script src="{{ asset('/js/extensions/jquery/jquery.min.js') }}"></script>

{{-- Sweet Alert --}}
<script src="{{ asset('/js/extensions/sweetalert2/sweetalert2@11.js') }}"></script>
{{-- Datatable --}}
<script src="{{ asset('/js/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

{{-- Icon fontawesome --}}
<script src="{{ asset('/icon/font-awesome.js') }}" crossorigin="anonymous"></script>
{{-- Apexcharts --}}
<script src="{{ asset('/js/extensions/apexcharts/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('/js/pages/dashboard.js') }}"></script> --}}

{{-- Pdf Exporter --}}
<script src="{{ asset('/js/extensions/exporter/html2pdf.bundle.js') }}"></script>

<!-- Excel Exporter -->
<script src="{{ asset('/js/extensions/exporter/xlsx.full.min.js') }}"></script>
{{-- Laravel Echo untuk komunikasi dengan serve channel --}}
<script src="{{ asset('/js/extensions/echo.js') }}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


<!-- DateRangePicker JS -->
<script src="{{ asset('/js/extensions/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('/js/extensions/daterangepicker/daterangepicker.js') }}"></script>

@livewireScripts
<script src="{{ asset('/js/main.js') }}"></script>

{{-- <script src="{{ asset('/js/app.js') }}"></script> --}}


{{ $script ?? '' }}

    
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ url('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ url('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ url('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ url('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

@if( in_array('datatables',$vendor) )
<script src="{{ url('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endif

<!-- Main JS -->
<script src="{{ url('assets/js/main.js') }}"></script>

<!-- Page JS -->
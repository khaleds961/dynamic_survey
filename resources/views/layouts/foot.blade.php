<!--  Import Js Files -->
<script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!--  core files -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<script src="{{ asset('dist/js/app.init.js') }}"></script>
<script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('dist/js/custom.js') }}"></script>
<script src="{{ asset('dist/libs/prismjs/prism.js') }}"></script>

<!--  current page js files -->
<script src="{{ asset('dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
{{-- <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('dist/js/dashboard.js') }}"></script>

{{-- Plus Minus Button --}}
{{-- <script src="{{ asset('dist/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('dist/js/forms/form-bootstrap-touchspin.init.js') }}"></script> --}}

{{-- Apex --}}
<script src="{{ asset('dist/js/apex-chart/apex.radial.init.js') }}"></script>
{{-- <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}

{{-- Apex Bar --}}
{{-- this folder you should change to get the real data --}}
{{-- <script src="{{ asset('dist/js/apex-chart/apex.bar.init.js') }}"></script> --}}

{{-- Active-inActive Button --}}
<script src="{{ asset('dist/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('dist/js/forms/bootstrap-switch.js') }}"></script>

{{-- SweetAlert --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Dropify --}}
<script src="{{ asset('dist/libs/dropify/js/dropify.js') }}"></script>
<script src="{{ asset('dist/libs/dropify/js/dropify.min.js') }}"></script>

{{-- FullCalendar --}}
<script src="{{ asset('dist/libs/fullcalendar/index.global.min.js') }}"></script>
{{-- <script src="{{ asset('dist/js/apps/calendar-init.js') }}"></script> --}}

{{-- Momemt Js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- RowReorder JS -->
<script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>

{{-- interphone --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.7/js/intlTelInput.min.js"
    integrity="sha512-DguTdnmuGKK87piEuhLZV1XZtEHUhfUmFC12IIQXVW36lbJ84tS9zHBBo2gMrXNJWxT8VZWsv/9Vu0k/vSpdpg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.7/js/intlTelInput-jquery.js"
    integrity="sha512-gkm7yhRikPhWl3Swwnj8iVWfRIttFHb1LyAfiJm/U+uzAE8hLyEMeJvYEIu8brD5ueBZzrv6l+9VaAuInmOhiQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.7/js/utils.js"></script>

{{-- Select2 --}}
<script src="{{ asset('dist/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('dist/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/forms/select2.init.js') }}"></script>

{{-- NEXT-PREVIOUS --}}
<script src="{{ asset('dist/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{ asset('dist/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dist/js/forms/form-wizard.js') }}"></script>

{{-- ckeditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script type="text/javascript">
    $('.dropify').dropify();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $("#loginTogglePassword").click(function() {
            var passwordInput = $("#exampleInputPassword1");
            var passwordIcon = $("#loginTogglePassword i");

            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                passwordIcon.removeClass("ti-eye").addClass("ti-eye-closed");
            } else {
                passwordInput.attr("type", "password");
                passwordIcon.removeClass("ti-eye-closed").addClass("ti-eye");
            }
        });
    });

    //register form password
    $(document).ready(function() {
        $("#togglePassword").click(function() {
            var passwordInput = $("#password");
            var passwordIcon = $("#togglePassword i");

            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                passwordIcon.removeClass("ti-eye").addClass("ti-eye-closed");
            } else {
                passwordInput.attr("type", "password");
                passwordIcon.removeClass("ti-eye-closed").addClass("ti-eye");
            }
        });
    });

    $(document).ready(function() {
        $("#toggleConfirmPassword").click(function() {
            var confirmPasswordInput = $("#confirm_password");
            var confirmPasswordIcon = $("#toggleConfirmPassword i");

            if (confirmPasswordInput.attr("type") === "password") {
                confirmPasswordInput.attr("type", "text");
                confirmPasswordIcon.removeClass("ti-eye").addClass("ti-eye-closed");
            } else {
                confirmPasswordInput.attr("type", "password");
                confirmPasswordIcon.removeClass("ti-eye-closed").addClass("ti-eye");
            }
        });
    });

    // start change status function
    $(document).on('change', '.change_status', function(event) {
        var id = $(this).data("id");
        var table_name = $(this).data("table_name");
        var action = $(this).data("action");

        event.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Are you sure you want to the change the status!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('change_status') }}",
                        method: 'post',
                        data: {
                            id: id,
                            table_name: table_name,
                            action: action
                        },
                        success: function(result) {
                            console.log(result)
                            swal("Poof! Your status has been changed successfully!", {
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                } else {
                    if ($(this).prop('checked') == true) {
                        $(this).prop('checked', false);
                    } else {
                        $(this).prop('checked', true);
                    }
                }
            });
    });

    //soft delete
    $(document).on('click', '.show_confirm', function(event) {
        var id = $(this).data("id");
        var table_name = $(this).data("table_name");
        var model = $(this).data("model");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this record ?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('custom_delete') }}",
                        method: 'post',
                        data: {
                            id: id,
                            table_name: table_name,
                            model: model
                        },
                        success: function(result) {
                            console.log(result);
                            swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                })
                                .then(() => {
                                    location.reload();
                                });
                        }
                    });
                }
            });
    });

    // flash message
    document.addEventListener("DOMContentLoaded", function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        }
    });

</script>

@stack('after-scripts')

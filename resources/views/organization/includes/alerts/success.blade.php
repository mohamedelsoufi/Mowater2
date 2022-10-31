@if(Session::has('success'))
    <script>
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": 'toast-top-left',
            }
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif

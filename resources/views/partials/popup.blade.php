@if (session('error'))

    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: '{{ session('error') }}'
            })
    </script>
@endif

@if (session('success'))

<script>
    Swal.fire({
        icon: 'success',
        title: 'success',
        text: '{{ session('success') }}'
        })
</script>
@endif
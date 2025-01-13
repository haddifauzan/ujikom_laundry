<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Success Alert Configuration
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                backdrop: 'rgba(15, 118, 110, 0.1) left top no-repeat'
            });
        @endif
    
        // Error Alert Configuration
        @if ($errors->any())
            let errorList = '<ul class="list-disc pl-4 mt-2">';
            @foreach ($errors->all() as $error)
            errorList += `<li class="text-left text-sm my-1">{{ $error }}</li>`;
            @endforeach
            errorList += '</ul>';

            Swal.fire({
            title: 'Oops...',
            icon: 'error',
            iconColor: '#dc2626',
            html: `
                <div class="mb-3 text-red-600 font-medium">Something went wrong!</div>
                ${errorList}
            `,
            position: 'center',
            showConfirmButton: true,
            confirmButtonText: 'Got it',
            confirmButtonColor: '#dc2626',
            backdrop: 'rgba(220, 38, 38, 0.1) left top no-repeat'
            });
        @endif

        // Session Error Alert Configuration
        @if (session('error'))
            Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: "error",
            iconColor: '#dc2626',
            position: 'center',
            showConfirmButton: true,
            confirmButtonText: 'Okay',
            confirmButtonColor: '#dc2626',
            backdrop: 'rgba(220, 38, 38, 0.1) left top no-repeat'
            });
        @endif

        // Info Alert Configuration
        @if (session('info'))
            Swal.fire({
                title: 'Information',
                text: "{{ session('info') }}",
                icon: 'info',
                iconColor: '#3b82f6',
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'Okay',
                confirmButtonColor: '#3b82f6',
                backdrop: 'rgba(59, 130, 246, 0.1) left top no-repeat'
            });
        @endif
    });
</script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<select id="myDropdown" style="width: 100%;" name="myDropdown"></select>

<script>
    
    $(document).ready(function () {
    $('#myDropdown').select2({
        placeholder: 'Search...',
        ajax: {
            url: 'fetch_data.php', // Your PHP script
            type: 'GET',
            dataType: 'json',
            delay: 250, // Delay in milliseconds
            data: function (params) {
                return {
                    search: params.term, // Search term entered by the user
                    page: params.page || 1 // Pagination support
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: data.more // Show more results if available
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 2 // Start search after 2 characters
    });
    // for Default Value
    $('#myDropdown').val('680').trigger('change');
});

</script>

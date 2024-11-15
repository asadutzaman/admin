<x-header />
<x-sidebar />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Examples Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Examples</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Button to Open Modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="addExampleBtn">Add Example</button>

            <!-- Examples Table -->
            <div class="mt-4">
                <input type="text" id="searchBox" class="form-control mb-3" placeholder="Search Examples...">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="examplesTable">
                        <!-- AJAX-loaded content -->
                    </tbody>
                </table>
                <div id="paginationLinks">
                    <!-- Pagination links will be dynamically loaded -->
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Example</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="exampleForm">
                                @csrf
                                <input type="hidden" id="exampleId" name="id">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" class="form-control" id="inputName" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Description</label>
                                    <input type="text" class="form-control" id="inputDescription" name="description" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrice">Price</label>
                                    <input type="text" class="form-control" id="inputPrice" name="price" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<x-footer />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Load examples
        function loadExamples(query = '', page = 1) {
            $.ajax({
                url: '{{ route("example.index") }}',
                type: 'GET',
                data: {
                    query,
                    page
                },
                success: function(data) {
                    $('#examplesTable').html(data.tableData);
                    $('#paginationLinks').html(data.pagination);
                }
            });
        }

        loadExamples();

        // Search functionality
        $('#searchBox').on('input', function() {
            const query = $(this).val();
            loadExamples(query);
        });

        // Open Add Example Modal
        $('#addExampleBtn').click(function() {
            $('#exampleModalLabel').text('Add Example');
            $('#exampleForm')[0].reset();
            $('#exampleId').val('');
        });

        // Form submission (Add/Edit)
        $('#exampleForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '{{ route("example.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    loadExamples();
                },
                error: function(response) {
                    alert('Failed to save the example.');
                }
            });
        });

        // Edit Example
        $(document).on('click', '.editExampleBtn', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `{{ url('example') }}/${id}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#exampleModalLabel').text('Edit Example');
                    $('#exampleId').val(data.id);
                    $('#inputName').val(data.name);
                    $('#inputDescription').val(data.description);
                    $('#inputPrice').val(data.price);
                    $('#exampleModal').modal('show');
                }
            });
        });

        // Delete Example
        $(document).on('click', '.deleteExampleBtn', function() {
            if (confirm('Are you sure?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: `{{ url('example') }}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        loadExamples();
                    },
                    error: function() {
                        alert('Failed to delete the example.');
                    }
                });
            }
        });

        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            const query = $('#searchBox').val();
            loadExamples(query, page);
        });
    });
</script>
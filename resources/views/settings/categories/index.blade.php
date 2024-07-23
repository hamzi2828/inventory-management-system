<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="datatable table w-100 table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Parant</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($categories) > 0)
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $category -> parent_id }}</td>
                                                    <td>{{ $category -> title }}</td>
                                                    <td>
                                                        <div class="align-content-start d-flex justify-content-start">
                                                            @can('edit', $category)
                                                                <a class="btn btn-primary btn-sm d-block mb-25 me-25"
                                                                   href="{{ route ('categories.edit', ['category' => $category -> id]) }}">
                                                                    Edit
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', $category)
                                                                <form method="post"
                                                                      id="delete-confirmation-dialog-{{ $category -> id }}"
                                                                      action="{{ route ('categories.destroy', ['category' => $category -> id]) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button"
                                                                            onclick="delete_dialog({{ $category -> id }})"
                                                                            class="btn btn-danger btn-sm d-block w-100">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                              
                                                            @can('delete', $category)
                                                          
                                                                <form method="post" class="mb-25" action="{{ route('category.status', ['category' => $category->id]) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                
                                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm d-block w-100">
                                                                        {{ $category->status === 'active' ? ' Activated' : 'Deactivated' }}
                                                                    </button>
                                                                </form>
                                                           
                                                        @endcan


                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            $ ( "div.head-label" ).html ( '<h4 class="fw-bolder mb-0">{{ $title }}</h6>' );
        </script>

<script>  
    // Convert PHP array to JavaScript object
    const categories = @json($categories);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create a map of category IDs to titles
        const categoryMap = categories.reduce((map, category) => {
            map[category.id] = category.title;
            return map;
        }, {});

        // Select all rows in the table
        const rows = document.querySelectorAll('.datatable tbody tr');

        rows.forEach(row => {
            const parentIdCell = row.querySelector('td:nth-child(2)'); // Adjust if the column position changes
            const parentId = parentIdCell.textContent.trim();

            // If parentId is not null or empty, replace it with the title
            if (parentId && categoryMap[parentId]) {
                parentIdCell.textContent = categoryMap[parentId];
            }
        });
    });
</script>

    @endpush
</x-dashboard>
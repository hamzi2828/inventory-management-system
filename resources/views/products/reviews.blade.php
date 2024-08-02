<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <!-- Basic table --> 
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table w-100 table-striped table-responsive" id="excel-table">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Actions</th>
                                            <th></th>
                                            <th>Sku</th>
                                            <th>Product</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Phone</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($reviews) > 0)
                                            @foreach($reviews as $review)
                                                <tr>
                                                    <td align="center">{{ $loop -> iteration }}</td>
                                                    <td>
                                                        <form method="post" class="mb-1"
                                                              id="confirmation-dialog-{{ $review -> id }}"
                                                              action="{{ route ('reviews.update', ['review' => $review -> id]) }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button"
                                                                    onclick="confirm_dialog('{{ $review -> id }}')"
                                                                    class="btn btn-success btn-sm d-block w-100">
                                                                Approve/Disapprove
                                                            </button>
                                                        </form>
                                                        
                                                        <form method="post"
                                                              id="delete-confirmation-dialog-{{ $review -> id }}"
                                                              action="{{ route ('reviews.destroy', ['review' => $review -> id]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="button"
                                                                    onclick="delete_dialog({{ $review -> id }})"
                                                                    class="btn btn-danger btn-sm d-block w-100">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        @if(!empty(trim ($review -> product ?-> image)))
                                                            <div class="avatar avatar-lg">
                                                                <img src="{{ asset ($review -> product -> image) }}">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $review -> product -> sku }}</td>
                                                    <td>{{ $review -> product -> productTitle() }}</td>
                                                    <td> 
                                                        @if ($review->user_id)
                                                            {{ $review -> user ?-> name }}
                                                            @else
                                                            {{ $review->user_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($review->user_id)
                                                            {{ $review -> user ?-> email }}
                                                            @else
                                                            {{ $review->email }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $review -> user ?-> phone }}</td>
                                                    <td>{{ $review -> rating }}</td>
                                                    <td>{{ $review -> review }}</td>
                                                    <td>
                                                        @if($review -> active == '1')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-warning">Inactive</span>
                                                        @endif
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
    @endpush
</x-dashboard>

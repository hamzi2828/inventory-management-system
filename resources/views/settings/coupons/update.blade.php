<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('coupons.update', ['coupon' => $coupon -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" name="title" autofocus="autofocus"
                                                       value="{{ old ('title', $coupon -> title) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="code">Code</label>
                                                <input type="text" id="code" class="form-control"
                                                       required="required" name="code"
                                                       value="{{ old ('code', $coupon -> code) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="discount">Discount (%)</label>
                                                <input type="number" step="any" id="discount" class="form-control"
                                                       required="required" name="discount" min="0" max="100"
                                                       value="{{ old ('discount', $coupon -> discount) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="start-date">Start Date</label>
                                                <input type="text" id="start-date" class="form-control flatpickr-basic"
                                                       name="start-date"
                                                       value="{{ old ('start-date', $coupon -> start_date) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="end-date">End Date</label>
                                                <input type="text" id="end-date" class="form-control flatpickr-basic"
                                                       name="end-date"
                                                       value="{{ old ('end-date', $coupon -> end_date) }}" />
                                            </div>
                                            
                                            <div class="col-md-9 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="description">Description</label>
                                                <textarea id="description" class="form-control"
                                                          name="description"
                                                          rows="3">{{ old ('description', $coupon -> description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>
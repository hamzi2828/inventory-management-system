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
                                      action="{{ route ('home-settings.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="col-md-12 mb-1">
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_1)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_1 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-1">
                                                            Banner 1
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-1"
                                                               id="banner-1" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_2)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_2 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-2">
                                                            Banner 2
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-2"
                                                               id="banner-2" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_3)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_3 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-3">
                                                            Banner 3
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-3"
                                                               id="banner-3" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_4)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_4 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-4">
                                                            Banner 4
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-4"
                                                               id="banner-4" />
                                                    </div>
                                                </div>
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

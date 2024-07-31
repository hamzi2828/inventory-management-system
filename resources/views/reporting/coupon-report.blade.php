<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                               <div class="card-body">
                                <div class="card-body">
                                    <form method="get" action="{{ route('coupon-search-report') }}" id="general-sales-report">
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-50">Coupons</label>
                                                <select name="coupon-id" class="form-control select2" data-placeholder="Select">
                                                    <option></option>
                                                    @if(count($coupons) > 0)
                                                        @foreach($coupons as $coupon)
                                                            <option value="{{ $coupon->id }}" {{ $coupon->id == request('coupon-id') ? 'selected' : '' }}>
                                                                {{ $coupon->code }} - {{ $coupon->description }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('coupon-id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" name="start-date" value="{{ request('start-date') }}">
                                                @error('start-date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic" name="end-date" value="{{ request('end-date') }}">
                                                @error('end-date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit" class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                </div>

                                {{-- @if(count ($sales) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('general-sales-invoice', ['customer-id' => request ('customer-id'), 'user-id' => request ('user-id'), 'branch-id' => request ('branch-id'), 'start-date' => request ('start-date'), 'end-date' => request ('end-date')]) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif --}}

                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sale ID</th>
                                            <th>Copoun Code</th>
                                            <th>Date Created  </th>
                                            <th>User</th>
                                          
                                        </tr>
                                        </thead>
                                   
                                        <tbody>
                                            @if(count($coupons_report) > 0)
                                                @foreach($coupons_report as $index => $coupon)
                                                    @foreach($coupon['sales'] as $sale)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $sale['sale_id'] }}</td>
                                                            <td>{{ $coupon['code'] }}</td>
                                                            <td>{{ $sale['created_at'] }}</td>
                                                            <td>{{ isset($sale['user']['name']) ? $sale['user']['name'] : 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">No coupons found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        
                                        {{-- <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalPrice, 2) }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalNetPrice, 2) }}</strong>
                                            </td>
                                        </tr>
                                        </tfoot> --}}
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
</x-dashboard>
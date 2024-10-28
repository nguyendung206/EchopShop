<!-- Modal thêm-->
<div class="modal fade" id="wardModal" tabindex="-1" role="dialog" aria-labelledby="wardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wardModalLabel">@lang('Cập nhật thông tin ') {{$districts->first()->province_id}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="wardForm" action="{{route('admin.feeship.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="province_id" value="{{$districts->first()->province_id}}" class="@error('province_id') is-invalid @enderror">
                    <input type="hidden" name="district_id" id="district_id" class="@error('district_id') is-invalid @enderror">
                    @error('province_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('district_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="ward-select">@lang('Chọn Phường/Xã')</label>
                        <select class="form-control @error('ward_id') is-invalid @enderror" id="ward-select" name="ward_id">
                            <option value="">@lang('--Chọn Phường/Xã--')</option>
                            <!-- Danh sách từ ajax -->
                        </select>
                        @error('ward_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('Tên')</label>
                        <input type="text" class="form-control @error('feename') is-invalid @enderror" id="name" name="feename" placeholder="@lang('Nhập tên')">
                        @error('feename')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('Giá')</label>
                        <input type="number" class="form-control @error('feeship') is-invalid @enderror" id="price" name="feeship" placeholder="@lang('Nhập giá')">
                        @error('feeship')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">@lang('Mô tả')</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="@lang('Nhập mô tả')"></textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary float-right">@lang('Lưu')</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Feeship -->
<div class="modal fade" id="feeshipModal" tabindex="-1" role="dialog" aria-labelledby="feeshipModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feeshipModalLabel">@lang('Thông tin phí vận chuyển')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Bảng dữ liệu -->
                    <div class="col-md-7">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 130px;">@lang('Phường/Xã')</th>
                                    <th style="width: 100px;">@lang('Tên')</th>
                                    <th style="width: 100px;">@lang('Giá')</th>
                                    <th>@lang('Mô tả')</th>
                                    <th style="width: 100px;">@lang('Hành động')</th>
                                </tr>
                            </thead>
                            <tbody id="feeship-data">
                                <!-- Dữ liệu sẽ được thêm vào đây -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Form chỉnh sửa -->
                    <div class="col-md-5">
                        <form id="feeshipForm" method="post">
                            @csrf
                            <input type="hidden" id="id">
                            <input type="hidden" id="wardId" name="ward_id">
                            <div class="form-group">
                                <label for="wardName">@lang('Tên Phường/Xã')</label>
                                <input type="text" class="form-control" id="wardName" readonly>
                            </div>

                            <div class="form-group">
                                <label for="feename">@lang('Tên Phí')</label>
                                <input type="text" class="form-control @error('feename') is-invalid @enderror" id="feename" name="feename" value="{{ old('feename') }}">
                                @error('feename')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="feeship">@lang('Giá')</label>
                                <input type="number" class="form-control @error('feeship') is-invalid @enderror" id="feeship" name="feeship" value="{{ old('feeship') }}">
                                @error('feeship')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="feeshipDescription">@lang('Mô tả')</label>
                                <textarea class="form-control @error('feeshipDescription') is-invalid @enderror" id="feeshipDescription" name="feeshipDescription" rows="4">{{ old('feeshipDescription') }}</textarea>
                                @error('feeshipDescription')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary float-right">@lang('Lưu')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
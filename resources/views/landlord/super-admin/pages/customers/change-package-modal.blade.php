<div id="editChangePackageModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> @lang('file.Change Package') </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('customer.change_package','saastest9') }}" id="packageUpdateForm" method="POST">
                    @csrf
                    <input type="hidden" name="tenant_id" id="tenantId">
                    <div class="row">
                        <div class="col-md-6">
                            <label><strong>@lang('file.Package')</strong></label>
                            <select name="package_id" id="packageIdChange" class="selectpicker form-control">
                                @foreach ($packages as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="updateButtonPackage">@lang('file.Update')</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

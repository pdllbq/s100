<div class="modal fade" id="news-filter-edit-modal" tabindex="-1" role="dialog" aria-labelledby="newsFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modla-title">{{ __('admin.Edit filter') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="edit_filter_modal_error" style="display:none;"></div>
                @csrf
                <div class="form-group">
                    <label for="edit_filter_name">{{ __('admin.Filter name') }}</label>
                    <input type="text" class="form-control" name="edit_filter_name" id="edit_filter_name" placeholder="{{ __('admin.Filter name') }}">
                </div>
                <div class="form-group">
                    <label for="edit_source_lang">{{ __('admin.Filter language') }}</label>
                    <select class="form-control" name="edit_filter_lang" id="edit_filter_lang">
                        <option value="ru">RU</option>
                        <option value="lv">LV</option>
                    </select>
                </div>
                <input type="hidden" name="edit_filter_id" id="edit_filter_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.Close') }}</button>
                <button 
                    type="button" 
                    class="btn btn-primary"
                    onclick="newsFilterEditSave('{{ route('admin.news.filters.update',[app()->getLocale()]) }}');"
                >
                    {{ __('admin.Save changes') }}
                </button>
            </div>
        </div>
    </div>
</div>
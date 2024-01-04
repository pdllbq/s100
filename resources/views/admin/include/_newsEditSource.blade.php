<div class="modal fade" id="news-source-edit-modal" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modla-title">{{ __('admin.Edit source') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="edit_source_modal_error" style="display:none;"></div>
                @csrf
                <div class="form-group">
                    <label for="edit_source_url">{{ __('admin.Source url') }}</label>
                    <input type="text" class="form-control" name="edit_source_url" id="edit_source_url" placeholder="{{ __('admin.Source url') }}">
                </div>
                <div class="form-group">
                    <label for="edit_source_lang">{{ __('admin.Source language') }}</label>
                    <select class="form-control" name="edit_source_lang" id="edit_source_lang">
                        <option value="ru">RU</option>
                        <option value="lv">LV</option>
                    </select>
                </div>
                <input type="hidden" name="edit_source_id" id="edit_source_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.Close') }}</button>
                <button 
                    type="button" 
                    class="btn btn-primary"
                    onclick="newsSourceEditSave('news-source-edit-modal','success-message','{{ route('admin.news.update',[app()->getLocale()]) }}');"
                >
                    {{ __('admin.Save changes') }}
                </button>
            </div>
        </div>
    </div>
</div>
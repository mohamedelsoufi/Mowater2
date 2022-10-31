<form action="{{route('organization.org-branches-users.delete',$user['id'])}}"
      method="POST" style="display: inline-block">
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <input type="hidden" name="organizable_type" value="{{$user['organizable_type']}}">
    <input type="hidden" name="organizable_id" value="{{$user['organizable_id']}}">
    <div class="modal fade" id="ModalDelete{{$user['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.delete_confirm')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> {{ __('message.delete_message') }} <b class="text-danger">{{ $user['email'] }}</b></div>
                <div class="modal-footer">
                    <button type="button" class="btn gray btn-outline-secondary" data-dismiss="modal">{{__('words.cancel')}}</button>
                    <button type="submit" class="btn gray btn-outline-danger">{{__('words.delete')}}</button>
                </div>
            </div>
        </div>
    </div>

</form>




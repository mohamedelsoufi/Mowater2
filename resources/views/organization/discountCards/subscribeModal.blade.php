<form action="{{route('organization.discount-cards.subscribe',$discount_card->id)}}"
      method="POST" style="display: inline-block">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <div class="modal fade" id="ModalSubscribe{{$discount_card->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.subscribe')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> {{ __('message.subscribe_message') }} <b class="text-danger">{{ $discount_card->title }}</b></div>
                <div class="modal-footer">
                    <button type="button" class="btn gray btn-outline-secondary" data-dismiss="modal">{{__('words.cancel')}}</button>
                    <button type="submit" class="btn gray btn-outline-success">{{__('words.subscribe')}}</button>
                </div>
            </div>
        </div>
    </div>

</form>




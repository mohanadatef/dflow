@forelse($data as $notification)
    <div class="menu-item px-5">
        <a href="#" onclick="readNotifaction({{$notification->id}},'{{$notification->url()}}')"
           class="menu-link px-5">{{getCustomTranslation($notification->action) ." ". getCustomTranslation('in') . " : ". $notification->action_id ?? ""}}</a>
    </div>
@empty
    <div class="menu-item px-5">
        <a href="#"
           style="pointer-events: none"
           class="menu-link px-5">{{getCustomTranslation('no_records_to_display_in_this_time_range')}}</a>
    </div>
@endforelse
<div class="menu-item px-5" >
    <a href="{{route('notification.index')}}"
       class="menu-link px-5" style="text-align: center">{{getCustomTranslation('all')}}</a>
</div>
<script>
    $('#notification-count').html({{$data->where('is_read',0)->count()}});
</script>
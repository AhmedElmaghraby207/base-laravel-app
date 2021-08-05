<div class="alert alert-{{ $type }}" data-alert="m-alert">
    <button class="close" type="button" data-dismiss="m-alert">×</button>
    <small>{!! $message !!}</small>
    @foreach($errors as $err)
        <small>{{ $err }}</small>
    @endforeach
</div>



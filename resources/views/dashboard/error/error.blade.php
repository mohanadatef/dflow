<!-- errors -->
@if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success" align="center">
        {{ session()->get('message')  }}
    </div>
    @php
        session()->forget('message');
    @endphp@elseif(session()->has('message_false'))
    <div class="alert alert-danger" align="center">
        {{ session()->get('message_false') }}
    </div>
    @php
        session()->forget('message_false');
    @endphp
@endif
@yield('error')

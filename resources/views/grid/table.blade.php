<table id="jstable" class="display table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>
           @foreach($data->cols as $k=>$col)
                <td>
                    {!! $col !!}
                </td>
            @endforeach
            <td>@lang('panel.actions')</td>
        </tr>
    </thead>
    <tbody>
        @foreach($data->items as $item)
            <tr>
                @foreach($data->cols as $k=>$col)
                    <td>
                        {!! $item[$k] !!}
                    </td>
                @endforeach
                @if(!is_null($item['actions']))
                    <td width="200">
                        @foreach($item['actions'] as $action)
                           {!! $action !!}
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
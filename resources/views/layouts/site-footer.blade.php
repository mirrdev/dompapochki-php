@php($footer = \App\Http\Models\Settings::getFooter())

<div class="row">
    <div class="col-md-3 col-lg-2">
        <a class="navbar-brand" href="/"></a>
    </div>
    <div class="col-md-3 col-lg-4">
        <div>
            <strong>{!! $footer['footer_worktime_title'] !!}</strong>
            <p>{!! $footer['footer_worktime'] !!}</p>
        </div>
        <div>
            <strong>{!! $footer['footer_address_title'] !!}</strong>
            <p>
                {!! $footer['footer_address'] !!}
                <br>
                {!! $footer['footer_address_other'] !!}
            </p>
        </div>
    </div>
    <div class="col-md-3 col-lg-4">
        {!! $footer['footer_legal_information'] !!}
    </div>
    <div class="col-md-3 col-lg-2">
        &copy; {{date('Y', time())}} <p> <a href="https://dompapochki.by">Дом папочки</a></p>
    </div>
</div>

@if(count($filters) > 2)
    <div id="horizontal-nav">
        @php
            if($activeFilter == null){
                $cssClass = 'btn-secondary';
            }else{
                $cssClass = 'btn-outline-secondary';
            }
        @endphp

        <a class="btn {{ $cssClass }}" href="{{ route('news.index',[app()->getLocale()]) }}">{{ __('news.All') }}</a>

        @foreach ($filters as $filter)

            @php
                if($activeFilter != null && $activeFilter->slug == $filter->slug){
                    $cssClass = 'btn-secondary';
                }else{
                    $cssClass = 'btn-outline-secondary';
                }
            @endphp

            <a class="btn {{ $cssClass }}" href="{{ route('news.filter',[app()->getLocale(), $filter->slug]).'#'.$filter->slug }}">{{ $filter->name }}</a><span id="{{ $filter->slug }}"></span>
        @endforeach
    </div>
@endif


<script>
    const element = document.querySelector("#horizontal-nav");

    element.addEventListener('wheel', (event) => {
    event.preventDefault();

    element.scrollBy({
        left: event.deltaY < 0 ? -30 : 30,
        });
    });
</script>
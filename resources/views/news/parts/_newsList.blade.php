@php
    $i = 0;
    $newsCardsVariants = [
        '1b',
        '1s',
        '3s',
        '3s',
        '3s',
        '1s',
        '1b',
        '3s',
        '3s',
        '3s',
    ];

    $newsCardsVariantsCount = count($newsCardsVariants);
@endphp

@foreach ($newsList as $news)
    
    @include('news.parts._card-'.$newsCardsVariants[$i], compact('news'))

    @php
        $i++;

        if($i >= $newsCardsVariantsCount){
            $i = 0;
        }
    @endphp
@endforeach
<div class="col-12 col-md-6 col-lg-8">
    <div class="news-card-image-left d-flex align-items-stretch">
        @if($news->img_url)
            <img src="{{ $news->img_url }} " alt="{{ $news->title }}" class="img-fluid">
        @endif
    </div>
</div>
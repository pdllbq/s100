<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"  >
    <channel>

        <title>{{ __('rss.New posts') }}</title>
        <link>{{ url('/') }}</link>
        <description>{{ __('rss.New posts') }}</description>
        <language>{{ app()->getLocale() }}</language>
        <lastBuildDate>{{ date('D, d M Y H:i:s O') }}</lastBuildDate>
        <pubDate>{{ date('D, d M Y H:i:s O') }}</pubDate>


        @foreach($posts as $post)

            <?php
            if($post->group_slug!=null){
                $groupSlugOrUserName=$post->group_slug;
            }else{
                $groupSlugOrUserName='@'.$post->user_name;
            }
            ?>

            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('post.show',[app()->getLocale(),$groupSlugOrUserName,$post->slug]) }}</link>
                <description><![CDATA[{!! replaceRelativePaths($post->html) !!}]]></description>
                <pubDate>{{ date('D, d M Y H:i:s O', strtotime($post->created_at)) }}</pubDate>
                <guid>{{ route('post.show',[app()->getLocale(),$groupSlugOrUserName,$post->slug]) }}</guid>
                @if($post->author)
                    <dc:creator>{{ $post->user_name }}</dc:creator>
                @endif
                @if($post->categories)
                    <category>{{ $post->group->name }}</category>
                @endif
            </item>
        @endforeach

    </channel>
</rss>
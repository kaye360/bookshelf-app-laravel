
<x-layouts.app>

    @foreach ($community_posts as $post )
        {{ $post['type'] }}, {{ $post['title'] }}, {{ $post['username'] }} <br />
    @endforeach

</x-layouts.app>

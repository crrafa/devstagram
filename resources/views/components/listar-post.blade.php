@if ($posts->count())
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
  @foreach ( $posts as $post )
  <div>
    <a href="{{route('posts.show',['user'=>$post->user, 'post'=>$post])}}"> {{-- route model Binding --}}
      <img src="{{asset('uploads').'/'. $post->imagen}}" alt="Imagen del post {{$post->titulo}}">
    </a>
  </div>
  @endforeach
</div>
<div class="my-10">
  {{$posts->links()}}
</div>
@else
<p class="text-gray-600 uppercase text-sm text-center font-bold">No hay publicaciones, sigue a alguien</p>
@endif
{{--  @forelse ($posts as $post)
    <p>{{$post->titulo}}</p>
@empty
    <p>No hya posts</p>
@endforelse --}}
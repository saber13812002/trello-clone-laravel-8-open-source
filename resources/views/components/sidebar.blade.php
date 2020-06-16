<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    hello from sidebar {{$title}}
    <ul>
        @foreach($list('asdf') as $item)
            <li >
                {{$item}}
            </li>
        @endforeach
    </ul>
    sidebar slot:
    {{$slot}}
</div>

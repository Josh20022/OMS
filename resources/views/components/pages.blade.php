@if(count($pages) > 0)
    <ul class="ul profile_info_list">
        @foreach($pages as $id => $title)
            @if(!haveParent($id))
                @if(haveChildren($id))
                    @php
                        $children = getChildren($id);
                        $filteredChildren = array_intersect_key($pages, $children);
                    @endphp
                    <li>
                        <a class="page_link" href="{{ url(getProtocol() . $subdomain . '.' . getDomain() . '/page/' . $id) }}">
                            {{ $title }}
                        </a>
                        <ul>
                            @foreach($filteredChildren as $id => $title)
                                <li>
                                    <a class="page_link" href="{{ url(getProtocol() . $subdomain . '.' . getDomain() . '/page/' . $id) }}">
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a class="page_link" href="{{ url(getProtocol() . $subdomain . '.' . getDomain() . '/page/' . $id) }}">
                            {{ $title }}
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
@else
    <div class="alert alert-secondary" role="alert">
        No pages at the moment.
    </div>
@endif

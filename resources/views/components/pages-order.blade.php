<div class="col-12">
    <div class="card card-warning collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ ucfirst($category) }} order</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <ul id="page-{{ $category }}" class="draggable_list">
                @foreach($pages as $id => $title)
                    @if(!haveParent($id))
                        @if(haveChildren($id))
                            @php
                                $children = getChildren($id);
                                $filteredChildren = array_intersect_key(arrayKeyAdjust($pages), $children);
                            @endphp
                            <li data-id="{{ $id }}" data-title="{{ $title }}">
                                {{ $title }}
                                <ul class="sub_drag draggable_list">
                                    @foreach($filteredChildren as $id => $title)
                                        <li data-id="{{ $id }}" data-title="{{ $title }}">{{ $title }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li data-id="{{ $id }}" data-title="{{ $title }}">{{ $title }}</li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="card-footer clearfix">
            <button
                type="button"
                class="btn btn-warning set_order_btn"
                data-user="{{ $user }}"
                data-type="page"
                data-category="{{ $category }}"
            >
                Save order
            </button>
        </div>
    </div>
</div>

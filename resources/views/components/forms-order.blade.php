<div class="col-12">
    <div class="card card-warning collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Form order</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <ul id="form-" class="draggable_list">
                @foreach($forms as $id => $title)
                    <li data-id="{{ $id }}" data-title="{{ $title }}">{{ $title }}</li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer clearfix">
            <button
                type="button"
                class="btn btn-warning set_order_btn"
                data-user="{{ $user }}"
                data-type="form"
                data-category=""
            >
                Save order
            </button>
        </div>
    </div>
</div>

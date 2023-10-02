<div class="card card-primary collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Assigned pages</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Template</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $key => $page)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->category }}</td>
                        <td>
                            <a href="{{ route('pages.show', $page) }}" class="btn btn-info btn-flat">
                                <i class="fas fa-link"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

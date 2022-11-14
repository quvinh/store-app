@unless($breadcrumbs->isEmpty())
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($breadcrumb->url && !$loop->last)
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $breadcrumb->title }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <h4 class="page-title">
                    @php
                        $index = count($breadcrumbs) - 1;
                        foreach ($breadcrumbs as $key => $breadcrumbs) {
                            if ($key == $index) {
                                echo $breadcrumb->title;
                            }
                        }
                    @endphp
                </h4>
            </div>
        </div>
    </div>
@endunless

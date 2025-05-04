<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>{{__('local.Doctor')}}</th>
                <th>{{__('local.Time')}}</th>
                <th>{{__('local.Status')}}</th>
                <th>{{__('local.Samples (Quantity)')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visits as $visit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $visit->doctor->full_name }}</td>
                    <td>{{ $visit->scheduled_at->format('h:i A') }}</td>
                    <td>
                        <span class="badge bg-{{ $visit->status->color() }}">
                            {{ $visit->status->label() }}
                        </span>
                    </td>
                    <td>
                        @if($visit->samples->isNotEmpty())
                            <ul class="list-group-flush small">
                                @foreach($visit->samples as $sample)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                        <span>{{ $sample->name }} ({{ $sample->pivot->quantity }})</span>
                                        <span class="badge bg-{{ App\Enums\SampleVisitStatus::from($sample->pivot->status)->color() }}">
                                            {{ App\Enums\SampleVisitStatus::from($sample->pivot->status)->label() }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">{{__('local.No samples')}}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">{{__('local.No visits scheduled for today')}}.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

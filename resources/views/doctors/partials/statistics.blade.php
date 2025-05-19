<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{ __('local.Statistics') }}</h5>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="border border-info rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Total Visits') }}</h6>
          <div id="totalVisits" class="fs-3 fw-bold">0</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border border-warning rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Representatives') }}</h6>
          <div id="linkedRepresentatives" class="fs-3 fw-bold">0</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border border-success rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Completion Rate') }}</h6>
          <div id="completionRate" class="fs-3 fw-bold">0%</div>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <canvas id="doctorStatsChart" height="150"></canvas>
    </div>

    <div class="mt-4">
      <h5 class='"card-title"'>{{ __('local.Sample Utilization') }}</h5>
      <div class="row">
        <div class="col-md-4">
          <div class="border rounded border-info p-3 text-center">
            <h6 class="text-muted">{{ __('local.Total Assigned') }}</h6>
            <div id="totalAssigned" class="fs-3 fw-bold">0</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded border-warning p-3 text-center">
            <h6 class="text-muted">{{ __('local.Total Used') }}</h6>
            <div id="totalUsed" class="fs-3 fw-bold">0</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded border-success p-3 text-center">
            <h6 class="text-muted">{{ __('local.Utilization Rate') }}</h6>
            <div id="utilizationRate" class="fs-3 fw-bold">0%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

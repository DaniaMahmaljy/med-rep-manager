<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{ __('local.Statistics') }}</h5>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="border border-info  rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Total Visits') }}</h6>
          <div id="totalVisits" class="fs-3 fw-bold">0</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border border-warning rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Linked Doctors') }}</h6>
          <div id="linkedDoctors" class="fs-3 fw-bold">0</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border border-success rounded p-3 text-center">
          <h6 class="text-muted">{{ __('local.Completion Rate') }}</h6>
          <div id="completionRate" class="fs-3 fw-bold">0%</div>
        </div>
      </div>
    </div>

    <div class="chart-container" style="height: 300px; mt-4">
      <canvas id="repStatsChart" height="150"></canvas>
    </div>
  </div>
</div>

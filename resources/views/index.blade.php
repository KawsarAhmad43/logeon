<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logeon - Laravel Log Viewer</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Bootstrap JS (for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="{{ asset('vendor/logeon/css/logeon.css') }}">

</head>
<body class="py-4">

<!-- Modal for log details -->
<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logModalLabel">Log Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <pre id="logDetails" style="white-space: pre-wrap; word-wrap: break-word;"></pre>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container">

  <!-- Top Row: Filters (40%) + Chart (60%) -->
  <div class="row g-4">
    
    <!-- Filters (40%) -->
    <div class="col-lg-5">
      <div class="card filter-card p-4">
        <h5 class="mb-4">Filters</h5>
        <div class="mb-3">
          <label class="form-label fw-semibold">From Date</label>
          <input type="date" id="fromDate" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">To Date</label>
          <input type="date" id="toDate" class="form-control">
        </div>
        <div class="mb-4">
          <label class="form-label fw-semibold">Log Type</label>
          <select id="typeFilter" class="form-select">
            <option value="">All Types</option>
            <option value="info">Info</option>
            <option value="error">Error</option>
            <option value="warn">Warning</option>
            <option value="custom">Custom</option>
          </select>
        </div>
        <button id="applyFilters" class="btn btn-primary w-100">Apply Filters</button>
      </div>
    </div>

    <!-- Chart + Legend (60%) -->
    <div class="col-lg-7">
      <div class="card chart-card p-4 d-flex flex-column">
        <h5 class="mb-4">Log Distribution</h5>
        <div class="row flex-grow-1 align-items-center">
          <div class="col-md-7">
            <canvas id="logPieChart" height="220"></canvas>
          </div>
          <div class="col-md-5">
            <div class="d-grid gap-3">
              <div class="log-type-badge badge-info active" data-type="info">
                <div class="d-flex justify-content-between">
                  <span>Info</span>
                  <strong id="infoCount">0</strong>
                </div>
              </div>
              <div class="log-type-badge badge-error" data-type="error">
                <div class="d-flex justify-content-between">
                  <span>Error</span>
                  <strong id="errorCount">0</strong>
                </div>
              </div>
              <div class="log-type-badge badge-warn" data-type="warn">
                <div class="d-flex justify-content-between">
                  <span>Warning</span>
                  <strong id="warnCount">0</strong>
                </div>
              </div>
              <div class="log-type-badge badge-custom" data-type="custom">
                <div class="d-flex justify-content-between">
                  <span>Custom</span>
                  <strong id="customCount">0</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Row: Logs Table (100%) -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card logs-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5>Recent Logs</h5>
          <small class="text-muted">Showing <span id="shownCount">10</span> of <span id="totalLogs">0</span> logs</small>
        </div>

        <div class="table-container">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th width="180">Timestamp</th>
                <th width="100">Type</th>
                <th>Message</th>
              </tr>
            </thead>
            <tbody id="logsTableBody">
              <!-- Filled by JS -->
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
          <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<script>
  // Set the API endpoint dynamically
  window.LOGEON_API_URL = '{{ route("logeon.logs") }}';
</script>
<script src="{{ asset('vendor/logeon/js/logeon.js') }}"></script>

</body>
</html>


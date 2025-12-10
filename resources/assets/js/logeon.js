// Fetch real logs from API (replace dummy data)
let logs = [];
let filteredLogs = [];
let selectedTypeFromBadge = '';
let pieChart;
const itemsPerPage = 10;
let currentPage = 1;

// Fetch logs on load
const apiUrl = window.LOGEON_API_URL || '/logger/logs';
fetch(apiUrl)
  .then(response => response.json())
  .then(data => {
    logs = data;
    filteredLogs = [...logs];
    updateChartAndCounts();
    renderTable();
  })
  .catch(error => console.error('Error fetching logs:', error));

function updateChartAndCounts() {
  const counts = { info: 0, error: 0, warn: 0, custom: 0 };
  filteredLogs.forEach(l => {
    if (counts.hasOwnProperty(l.type)) {
      counts[l.type]++;
    }
  });
  ['info', 'error', 'warn', 'custom'].forEach(t => {
    document.getElementById(t + 'Count').textContent = counts[t];
  });
  if (pieChart) pieChart.destroy();
  pieChart = new Chart(document.getElementById('logPieChart'), {
    type: 'doughnut',
    data: {
      labels: ['Info', 'Error', 'Warning', 'Custom'],
      datasets: [{
        data: [counts.info, counts.error, counts.warn, counts.custom],
        backgroundColor: ['#0dcaf0', '#dc3545', '#fd7e14', '#6f42c1'],
        borderWidth: 3,
        borderColor: '#fff',
        hoverBorderWidth: 4,
        hoverOffset: 12
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => {
              const val = ctx.parsed;
              const total = filteredLogs.length;
              const percent = total ? Math.round(val / total * 100) : 0;
              return `${val} logs (${percent}%)`;
            }
          }
        }
      }
    }
  });
}

function renderTable() {
  const start = (currentPage - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  const pageData = filteredLogs.slice(start, end);
  const tbody = document.getElementById('logsTableBody');
  tbody.innerHTML = '';
  pageData.forEach(log => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="text-muted">${log.ts}</td>
      <td><span class="badge badge-${log.type}">${log.type.toUpperCase()}</span></td>
      <td>${log.msg}</td>
    `;
    tr.style.cursor = 'pointer';  // Make row clickable
    tr.onclick = () => showModal(log);  // Open modal on click
    tbody.appendChild(tr);
  });
  document.getElementById('shownCount').textContent = pageData.length;
  document.getElementById('totalLogs').textContent = filteredLogs.length;
  renderPagination();
}

function renderPagination() {
  const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
  if (totalPages <= 1) {
    document.getElementById('pagination').innerHTML = '';
    return;
  }

  const ul = document.getElementById('pagination');
  ul.innerHTML = '';

  const maxVisible = 7; // You can change to 5, 7, 9 etc.
  let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let endPage = Math.min(totalPages, startPage + maxVisible - 1);

  // Adjust startPage if we're near the end
  if (endPage - startPage + 1 < maxVisible) {
    startPage = Math.max(1, endPage - maxVisible + 1);
  }

  // Helper to create page item
  const createPageItem = (page, text = page, isActive = false, isDisabled = false) => {
    const li = document.createElement('li');
    li.className = `page-item ${isActive ? 'active' : ''} ${isDisabled ? 'disabled' : ''}`;

    const a = document.createElement('a');
    a.className = 'page-link';
    a.href = '#';
    a.textContent = text;

    if (!isDisabled && !isActive) {
      a.onclick = (e) => {
        e.preventDefault();
        currentPage = page;
        renderTable();
      };
    }

    li.appendChild(a);
    return li;
  };

  // Previous Button
  ul.appendChild(createPageItem(currentPage - 1, 'Previous', false, currentPage === 1));

  // First Page + Ellipsis if needed
  if (startPage > 1) {
    ul.appendChild(createPageItem(1, '1'));
    if (startPage > 2) {
      const ellipsis = document.createElement('li');
      ellipsis.className = 'page-item disabled';
      ellipsis.innerHTML = '<a class="page-link">...</a>';
      ul.appendChild(ellipsis);
    }
  }

  // Page numbers
  for (let i = startPage; i <= endPage; i++) {
    ul.appendChild(createPageItem(i, i, i === currentPage));
  }

  // Last Page + Ellipsis if needed
  if (endPage < totalPages) {
    if (endPage < totalPages - 1) {
      const ellipsis = document.createElement('li');
      ellipsis.className = 'page-item disabled';
      ellipsis.innerHTML = '<a class="page-link">...</a>';
      ul.appendChild(ellipsis);
    }
    ul.appendChild(createPageItem(totalPages, totalPages));
  }

  // Next Button
  ul.appendChild(createPageItem(currentPage + 1, 'Next', false, currentPage === totalPages));
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function applyFilters() {
  const from = document.getElementById('fromDate').value;
  const to = document.getElementById('toDate').value;
  const type = document.getElementById('typeFilter').value || selectedTypeFromBadge;
  filteredLogs = logs.filter(log => {
    const logDate = log.ts.split(' ')[0];
    const dateOk = (!from || logDate >= from) && (!to || logDate <= to);
    const typeOk = !type || log.type === type;
    return dateOk && typeOk;
  });
  currentPage = 1;
  updateChartAndCounts();
  renderTable();
}

// Show modal with details
function showModal(log) {
  document.getElementById('logDetails').textContent = log.details;
  const modal = new bootstrap.Modal(document.getElementById('logModal'));
  modal.show();
}

// Badge click for type filter
document.querySelectorAll('.log-type-badge').forEach(badge => {
  badge.addEventListener('click', () => {
    const type = badge.dataset.type;
    if (selectedTypeFromBadge === type) {
      selectedTypeFromBadge = '';
      badge.classList.remove('active');
    } else {
      document.querySelectorAll('.log-type-badge').forEach(b => b.classList.remove('active'));
      badge.classList.add('active');
      selectedTypeFromBadge = type;
    }
    document.getElementById('typeFilter').value = selectedTypeFromBadge;
    applyFilters();
  });
});

// Apply filters button
document.getElementById('applyFilters').addEventListener('click', applyFilters);
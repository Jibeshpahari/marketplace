<div id="subnav">

      <div class="subnav-item active">Overview</div>

      <div class="sn-dropdown">
        <div class="subnav-item">Reports <i class="fa-solid fa-chevron-down"></i></div>
        <div class="sn-dropdown-menu">
          <div class="dd-item"><i class="fa-regular fa-file-chart-column"></i>Sales Report</div>
          <div class="dd-item"><i class="fa-regular fa-chart-pie"></i>Revenue Breakdown</div>
          <div class="dd-item"><i class="fa-regular fa-users"></i>User Metrics</div>
          <div class="dd-sep"></div>
          <div class="dd-item"><i class="fa-regular fa-clock-rotate-left"></i>Scheduled Reports</div>
        </div>
      </div>

      <div class="sn-dropdown">
        <div class="subnav-item">Marketing <i class="fa-solid fa-chevron-down"></i></div>
        <div class="sn-dropdown-menu">
          <div class="dd-item"><i class="fa-regular fa-envelope"></i>Campaigns</div>
          <div class="dd-item"><i class="fa-regular fa-bullhorn"></i>Ads Manager</div>
          <div class="dd-item"><i class="fa-brands fa-instagram"></i>Social Media</div>
        </div>
      </div>

      <div class="sn-dropdown">
        <div class="subnav-item">Finance <i class="fa-solid fa-chevron-down"></i></div>
        <div class="sn-dropdown-menu">
          <div class="dd-item"><i class="fa-regular fa-receipt"></i>Invoices</div>
          <div class="dd-item"><i class="fa-regular fa-credit-card"></i>Payments</div>
          <div class="dd-item"><i class="fa-regular fa-file-invoice-dollar"></i>Tax Records</div>
          <div class="dd-sep"></div>
          <div class="dd-item"><i class="fa-regular fa-arrow-down-to-line"></i>Export</div>
        </div>
      </div>

      <div class="subnav-item">Integrations</div>
      <div class="subnav-item">Logs</div>

      <div class="subnav-right">
        <button class="sub-action-btn"><i class="fa-solid fa-filter"></i> Filter</button>
        <button class="sub-action-btn"><i class="fa-solid fa-arrow-down-to-line"></i> Export</button>
        <button class="sub-action-btn primary"><i class="fa-solid fa-plus"></i> New</button>
      </div>

    </div>

@push('js')
<script>
$(function () {

    $('.subnav-item:not(:has(.fa-chevron-down))').on('click', function () {
        $('.subnav-item').removeClass('active');
        $(this).addClass('active');
    });

});
</script>
@endpush
<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
    <div>
      <h1 class="text-3xl font-bold text-slate-900">Admins</h1>
      <p class="text-slate-600 mt-1">Manage administrator accounts</p>
    </div>
    <a href="/qlr/admin/new-admin" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-lg shadow-primary/30 transition-all">
      <i class="fas fa-plus"></i> Add Admin
    </a>
  </div>
  <div id="alertBox" class="hidden mb-4 p-4 rounded-lg"></div>
  <?php $rows = $pdo->query('SELECT id, email, status, created_at FROM admins ORDER BY created_at DESC')->fetchAll(); ?>
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Created</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
        <?php foreach ($rows as $r): 
          $status = $r['status'] ?? 'active';
          $statusColors = [
            'active' => 'bg-green-100 text-green-700',
            'suspended' => 'bg-yellow-100 text-yellow-700',
            'blocked' => 'bg-red-100 text-red-700'
          ];
        ?>
          <tr class="hover:bg-slate-50 transition-colors" data-admin-id="<?php echo $r['id']; ?>">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-slate-900"><?php echo htmlspecialchars($r['email']); ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2.5 py-1 text-xs font-semibold rounded-full <?php echo $statusColors[$status]; ?> admin-status">
                <?php echo ucfirst($status); ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo date('M d, Y', strtotime($r['created_at'])); ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center gap-2">
                <?php if ($status === 'active'): ?>
                  <button onclick="openStatusModal(<?php echo $r['id']; ?>, '<?php echo htmlspecialchars($r['email'], ENT_QUOTES); ?>', 'suspended')" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                    <i class="fas fa-pause-circle mr-1"></i> Suspend
                  </button>
                  <button onclick="openStatusModal(<?php echo $r['id']; ?>, '<?php echo htmlspecialchars($r['email'], ENT_QUOTES); ?>', 'blocked')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    <i class="fas fa-ban mr-1"></i> Block
                  </button>
                <?php elseif ($status === 'suspended'): ?>
                  <button onclick="changeStatus(<?php echo $r['id']; ?>, 'active')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    <i class="fas fa-check-circle mr-1"></i> Activate
                  </button>
                  <button onclick="openStatusModal(<?php echo $r['id']; ?>, '<?php echo htmlspecialchars($r['email'], ENT_QUOTES); ?>', 'blocked')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    <i class="fas fa-ban mr-1"></i> Block
                  </button>
                <?php elseif ($status === 'blocked'): ?>
                  <button onclick="changeStatus(<?php echo $r['id']; ?>, 'active')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    <i class="fas fa-check-circle mr-1"></i> Activate
                  </button>
                <?php endif; ?>
                <button onclick="openDeleteModal(<?php echo $r['id']; ?>, '<?php echo htmlspecialchars($r['email'], ENT_QUOTES); ?>')" class="text-red-600 hover:text-red-800 text-sm font-medium ml-2">
                  <i class="fas fa-trash mr-1"></i> Delete
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php if (count($rows) === 0): ?>
      <div class="p-12 text-center">
        <i class="fas fa-users text-4xl text-slate-300 mb-3"></i>
        <p class="text-slate-600">No admins found.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
      <i class="fas fa-trash text-red-600 text-xl"></i>
    </div>
    <h3 class="text-xl font-bold text-center text-slate-900 mb-2">Delete Admin Account</h3>
    <p class="text-center text-slate-600 mb-6">Are you sure you want to delete <strong id="deleteAdminEmail"></strong>? This action cannot be undone.</p>
    <div class="flex gap-3">
      <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
        Cancel
      </button>
      <button onclick="confirmDelete()" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
        Delete
      </button>
    </div>
  </div>
</div>

<!-- Status Change Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-yellow-100 rounded-full">
      <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
    </div>
    <h3 class="text-xl font-bold text-center text-slate-900 mb-2" id="statusModalTitle">Change Admin Status</h3>
    <p class="text-center text-slate-600 mb-6">Are you sure you want to <strong id="statusAction"></strong> <strong id="statusAdminEmail"></strong>?</p>
    <div class="flex gap-3">
      <button onclick="closeStatusModal()" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
        Cancel
      </button>
      <button onclick="confirmStatusChange()" class="flex-1 px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition">
        Confirm
      </button>
    </div>
  </div>
</div>

<script>
let currentAdminId = null;
let currentStatus = null;

function openDeleteModal(id, email) {
  currentAdminId = id;
  document.getElementById('deleteAdminEmail').textContent = email;
  document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
  document.getElementById('deleteModal').classList.add('hidden');
  currentAdminId = null;
}

function openStatusModal(id, email, status) {
  currentAdminId = id;
  currentStatus = status;
  document.getElementById('statusAdminEmail').textContent = email;
  document.getElementById('statusAction').textContent = status;
  document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
  document.getElementById('statusModal').classList.add('hidden');
  currentAdminId = null;
  currentStatus = null;
}

function confirmDelete() {
  if (!currentAdminId) return;
  
  $.ajax({
    url: '/qlr/admin/api/admin-actions.php',
    method: 'POST',
    data: { action: 'delete', admin_id: currentAdminId },
    dataType: 'json',
    success: function(res) {
      if (res.success) {
        showAlert('Admin deleted successfully', 'success');
        $('tr[data-admin-id="' + currentAdminId + '"]').fadeOut(300, function() { $(this).remove(); });
        closeDeleteModal();
      } else {
        showAlert(res.error || 'Failed to delete admin', 'error');
      }
    },
    error: function() {
      showAlert('Network error occurred', 'error');
    }
  });
}

function changeStatus(id, status) {
  $.ajax({
    url: '/qlr/admin/api/admin-actions.php',
    method: 'POST',
    data: { action: 'status', admin_id: id, status: status },
    dataType: 'json',
    success: function(res) {
      if (res.success) {
        showAlert('Status updated successfully', 'success');
        updateStatusBadge(id, status);
        location.reload(); // Reload to update action buttons
      } else {
        showAlert(res.error || 'Failed to update status', 'error');
      }
    },
    error: function() {
      showAlert('Network error occurred', 'error');
    }
  });
}

function confirmStatusChange() {
  if (!currentAdminId || !currentStatus) return;
  changeStatus(currentAdminId, currentStatus);
  closeStatusModal();
}

function updateStatusBadge(id, status) {
  const colors = {
    'active': 'bg-green-100 text-green-700',
    'suspended': 'bg-yellow-100 text-yellow-700',
    'blocked': 'bg-red-100 text-red-700'
  };
  const badge = $('tr[data-admin-id="' + id + '"] .admin-status');
  badge.attr('class', 'px-2.5 py-1 text-xs font-semibold rounded-full admin-status ' + colors[status]);
  badge.text(status.charAt(0).toUpperCase() + status.slice(1));
}

function showAlert(message, type) {
  const alertBox = $('#alertBox');
  const colors = {
    'success': 'bg-green-50 border-green-200 text-green-700',
    'error': 'bg-red-50 border-red-200 text-red-700'
  };
  const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
  alertBox.attr('class', 'mb-4 p-4 rounded-lg border ' + colors[type]);
  alertBox.html('<i class="fas fa-' + icon + ' mr-2"></i>' + message);
  alertBox.removeClass('hidden');
  setTimeout(() => alertBox.fadeOut(), 5000);
}

// Close modals on ESC key
$(document).keyup(function(e) {
  if (e.key === "Escape") {
    closeDeleteModal();
    closeStatusModal();
  }
});
</script>
</body>
</html>
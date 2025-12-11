<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?php 

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $contactId = intval($_POST['contact_id']);
    $newStatus = $_POST['status'];
    
    if (in_array($newStatus, ['new', 'read', 'replied', 'archived'])) {
        $stmt = $pdo->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $contactId]);
        header('Location: /qlr/admin/contacts?success=1');
        exit;
    }
}

// Fetch contacts with filters
$statusFilter = $_GET['filter'] ?? 'all';
$sql = "SELECT * FROM contacts";
if ($statusFilter !== 'all') {
    $sql .= " WHERE status = :status";
}
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
if ($statusFilter !== 'all') {
    $stmt->execute(['status' => $statusFilter]);
} else {
    $stmt->execute();
}
$contacts = $stmt->fetchAll();

// Count by status
$statusCounts = [
    'all' => $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn(),
    'new' => $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'new'")->fetchColumn(),
    'read' => $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'read'")->fetchColumn(),
    'replied' => $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'replied'")->fetchColumn(),
    'archived' => $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'archived'")->fetchColumn()
];
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
    <div>
      <h1 class="text-3xl font-bold text-slate-900">Contact Queries</h1>
      <p class="text-slate-600 mt-1">Manage customer inquiries</p>
    </div>
  </div>

  <?php if (isset($_GET['success'])): ?>
    <div id="successAlert" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
      <i class="fas fa-check-circle mr-2"></i> Status updated successfully!
    </div>
  <?php endif; ?>

  <!-- Status Filters -->
  <div class="mb-6 flex flex-wrap gap-2">
    <a href="/qlr/admin/contacts?filter=all" class="px-4 py-2 <?php echo $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-white text-slate-700 border border-slate-300'; ?> rounded-lg text-sm font-semibold transition hover:bg-primary hover:text-white">
      All (<?php echo $statusCounts['all']; ?>)
    </a>
    <a href="/qlr/admin/contacts?filter=new" class="px-4 py-2 <?php echo $statusFilter === 'new' ? 'bg-amber-500 text-white' : 'bg-white text-slate-700 border border-slate-300'; ?> rounded-lg text-sm font-semibold transition hover:bg-amber-500 hover:text-white">
      New (<?php echo $statusCounts['new']; ?>)
    </a>
    <a href="/qlr/admin/contacts?filter=read" class="px-4 py-2 <?php echo $statusFilter === 'read' ? 'bg-primary text-white' : 'bg-white text-slate-700 border border-slate-300'; ?> rounded-lg text-sm font-semibold transition hover:bg-primary hover:text-white">
      Read (<?php echo $statusCounts['read']; ?>)
    </a>
    <a href="/qlr/admin/contacts?filter=replied" class="px-4 py-2 <?php echo $statusFilter === 'replied' ? 'bg-green-500 text-white' : 'bg-white text-slate-700 border border-slate-300'; ?> rounded-lg text-sm font-semibold transition hover:bg-green-500 hover:text-white">
      Replied (<?php echo $statusCounts['replied']; ?>)
    </a>
    <a href="/qlr/admin/contacts?filter=archived" class="px-4 py-2 <?php echo $statusFilter === 'archived' ? 'bg-slate-500 text-white' : 'bg-white text-slate-700 border border-slate-300'; ?> rounded-lg text-sm font-semibold transition hover:bg-slate-500 hover:text-white">
      Archived (<?php echo $statusCounts['archived']; ?>)
    </a>
  </div>

  <!-- Contacts List -->
  <div class="space-y-4">
    <?php foreach ($contacts as $contact): 
      $statusColors = [
        'new' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'border' => 'border-amber-200'],
        'read' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'border' => 'border-orange-200'],
        'replied' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-200'],
        'archived' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200']
      ];
      $color = $statusColors[$contact['status']];
    ?>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
          <div class="flex-1">
            <div class="flex items-start gap-3 mb-3">
              <div class="flex-1">
                <h3 class="text-lg font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($contact['name']); ?></h3>
                <p class="text-sm text-slate-600 mb-2">
                  <i class="fas fa-envelope mr-1"></i>
                  <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="text-primary hover:underline">
                    <?php echo htmlspecialchars($contact['email']); ?>
                  </a>
                </p>
                <p class="text-xs text-slate-500">
                  <i class="fas fa-clock mr-1"></i>
                  <?php echo date('F j, Y · g:i A', strtotime($contact['created_at'])); ?>
                </p>
              </div>
              <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo $color['bg'] . ' ' . $color['text']; ?>">
                <?php echo ucfirst($contact['status']); ?>
              </span>
            </div>
            
            <div class="bg-slate-50 rounded-lg p-4 mt-3">
              <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap"><?php echo htmlspecialchars($contact['message']); ?></p>
            </div>
          </div>

          <div class="lg:min-w-[200px]">
            <form method="POST" class="space-y-3">
              <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
              <input type="hidden" name="update_status" value="1">
              
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Change Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50">
                  <option value="new" <?php echo $contact['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                  <option value="read" <?php echo $contact['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                  <option value="replied" <?php echo $contact['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                  <option value="archived" <?php echo $contact['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                </select>
              </div>

              <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="block w-full text-center px-3 py-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold rounded-lg transition">
                <i class="fas fa-reply mr-1"></i> Reply via Email
              </a>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (empty($contacts)): ?>
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
        <p class="text-slate-600">No contact queries found.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<script>
// Auto-hide success alert
setTimeout(() => {
  const alert = document.getElementById('successAlert');
  if (alert) {
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);
</script>
</body>
</html>

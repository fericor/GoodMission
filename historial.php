<?php 
    include 'control/db.php'; 
    include 'control/csrf.php';

    noLogin();

    $userId = $_SESSION['user_id'];
    $res = $conn->query("SELECT * FROM transactions WHERE user_id = $userId ORDER BY created_at DESC");
?>

<?php include_once 'includes/header.php'; ?>
<?php include_once 'modulos/wallet/menu_wallet.php'; ?>

<h4 class="text-xl font-semibold mb-4">Historial de transacciones</h4>
<div class="overflow-x-auto">
	<table class="min-w-full divide-y divide-gray-200">
		<thead class="bg-gray-50">
			<tr>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
			</tr>
		</thead>
		<tbody class="bg-white divide-y divide-gray-200">
		<?php while ($row = $res->fetch_assoc()): ?>
			<tr class="hover:bg-gray-50">
			<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $row['created_at'] ?></td>
			<td class="px-6 py-4 whitespace-nowrap">
				<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $row['type']=='add'?'bg-green-100 text-green-800':'bg-red-100 text-red-800' ?>">
				<?= $row['type'] ?>
				</span>
			</td>
			<td class="px-6 py-4 whitespace-nowrap text-sm <?= $row['type']=='add'?'text-green-600 font-medium':'text-red-600 font-medium' ?>">
				€<?= number_format($row['amount'], 2) ?>
			</td>
			<td class="px-6 py-4 text-sm text-gray-500"><?= $row['description'] ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>

<?php include 'includes/menu.php'; ?>
<?php include 'includes/footer.php'; ?>

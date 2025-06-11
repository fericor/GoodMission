<?php 
    include_once 'control/db.php'; 
    include_once 'control/csrf.php';

    noLogin();

    $TITLE_PAG = "GoodMission - Mi wallet";
?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

<?php
    $userId = $_SESSION['user_id'];
    $res = $conn->query("SELECT balance FROM users WHERE id = $userId");
    $balance = $res->fetch_assoc()['balance'];
?>

<a href="historial.php" class="bg-white text-blue-600 hover:bg-gray-100 px-3 py-1 rounded text-sm font-medium transition-colors"> Historial </a>

<!-- Saldo disponible -->
<div class="mb-6 p-4 bg-white rounded-lg shadow-sm">
  <h4 class="text-lg font-semibold text-gray-700">Saldo disponible: 
    <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
      €<?= number_format($balance, 2) ?>
    </span>
  </h4>
</div>

<div class="space-y-4">
	<!-- Agregar fondos -->
	<div class="bg-white rounded-lg shadow-sm overflow-hidden">
		<div class="p-5">
		<h5 class="text-lg font-medium text-gray-800 mb-4">Agregar fondos</h5>
		<form method="post" action="modulos/wallet/add_funds.php" onsubmit="return validateAmount(this)" class="space-y-3">
			<?= csrf_token() ?>
			<input type="number" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" placeholder="Monto" required />
			<button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"> Agregar </button>
		</form>
		</div>
	</div>

  	<!-- Realizar compra -->
  	<div class="bg-white rounded-lg shadow-sm overflow-hidden">
		<div class="p-5">
		<h5 class="text-lg font-medium text-gray-800 mb-4">Realizar compra</h5>
		<form method="post" action="modulos/wallet/make_purchase.php" onsubmit="return validatePurchase(this)" class="space-y-3">
			<?= csrf_token() ?>
			<input type="number" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" placeholder="Monto" required />
			<input type="text" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción" required />
			<button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-200"> Comprar </button>
		</form>

		<!-- Escáner QR -->
		<button onclick="scanQR()" class="w-full mt-4 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition duration-200">
			Escanear QR para pago
		</button>
		<video id="preview" class="w-full mt-2 hidden"></video>
		</div>
	</div>
</div>


<?php include 'includes/menu.php'; ?>
<?php include 'includes/footer.php'; ?>
